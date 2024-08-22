<?php

namespace App\Hooks;

/**
 * Class to handle cron jobs.
 */
class Cron {

    /**
     * Singleton instance
     *
     * @var Cron
     */
    private static $instance;

    /**
     * Initialization flag
     *
     * @var bool
     */
    private static $initialized = false;

    /**
     * Get singleton instance
     *
     * @return Cron
     */
    public static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    private function __construct() {
        // Schedule jobs when instance is created, if not already initialized
        error_log('Cron instance created'); // Log instance creation
        if (!self::$initialized) {
            $this->init();
        }
    }

    /**
     * Initialize the cron jobs.
     */
    public function init() {
        if (self::$initialized) {
            return; // Prevent multiple initializations
        }
        self::$initialized = true;

        self::schedule_jobs(HUBRIX_BACKEND_DIR . 'Jobs');
        self::schedule_jobs(HUBRIX_FRONTEND_DIR . 'Jobs');
    }

    /**
     * Unschedule all cron jobs.
     */
    public static function unschedule_all_jobs() {
        error_log('Unscheduling all cron jobs');

        self::unschedule_jobs(HUBRIX_BACKEND_DIR . 'Jobs');
        self::unschedule_jobs(HUBRIX_FRONTEND_DIR . 'Jobs');
    }

    /**
     * Unschedule jobs defined in the specified directory.
     *
     * @param string $directory The directory to load job classes from.
     */
    private static function unschedule_jobs($directory) {
        foreach (glob($directory . '/*.php') as $file) {
            require_once $file;
            $class_name = self::get_class_name_from_file($file);
            if (class_exists($class_name) && in_array(JobInterface::class, class_implements($class_name))) {
                $hook = 'hubrix_cron_job_' . strtolower($class_name);
                $timestamp = wp_next_scheduled($hook);
                if ($timestamp) {
                    error_log('Unscheduled hook: ' . $hook); // Add logging here
                    wp_unschedule_event($timestamp, $hook);
                }
            }
        }
    }

    /**
     * Schedule the jobs defined in the specified directory.
     *
     * @param string $directory The directory to load job classes from.
     */
    private static function schedule_jobs($directory) {
        error_log('scheduled jobs in directory: ' . $directory);
        foreach (glob($directory . '/*.php') as $file) {
            error_log('Loading job file: ' . $file);
            require_once $file;
            $class_name = self::get_class_name_from_file($file);
            error_log('Detected class: ' . $class_name);
            if (class_exists($class_name) && in_array(JobInterface::class, class_implements($class_name))) {
                $hook = 'hubrix_cron_job_' . strtolower($class_name);
                if (!wp_next_scheduled($hook)) {
                    wp_schedule_event(time(), 'daily', $hook);
                }
                add_action($hook, [$class_name, 'execute']);
            } else {
                error_log('Class ' . $class_name . ' does not exist or does not implement JobInterface');
            }
        }
    }

    /**
     * Get the class name from the file path.
     *
     * @param string $file The file path.
     * @return string The class name.
     */
    private static function get_class_name_from_file($file) {
        $contents = file_get_contents($file);
        $namespace = '';
        if (preg_match('/namespace\s+([^;]+);/', $contents, $matches)) {
            $namespace = $matches[1] . '\\';
        }
        if (preg_match('/class\s+([^\s]+)/', $contents, $matches)) {
            return $namespace . $matches[1];
        }
        return '';
    }
}
