<?php

namespace Hubrix\Providers;

use eftec\bladeone\BladeOne;
use Exception;

class BladeOneServiceProvider {

    // Blade instance
    private static $instance = null;

    /**
     * Register the BladeOne service
     * Description: This method is used to register the BladeOne service within the plugin.
     *
     * @throws Exception
     * @return void
     */
    public function register(): void
    {
        error_log("BladeOneServiceProvider::register() method is being called.");
        $this->setup();
    }

    /**
     * Set up the Blade environment
     * Description: This method is used to set up the Blade environment.
     *
     * @throws Exception
     * @return void
     */
    public static function setup() {
        self::getInstance();
    }

    /**
     * Get the Blade instance
     * Description: This method is used to get the Blade instance.
     *
     * @throws Exception
     * @return BladeOne|null
     */
    public static function getInstance() {
        if (is_null(self::$instance)) {
            $views = HUBRIX_ROOT_DIR . 'resources/views';
            $cache = HUBRIX_ROOT_DIR . 'storage/cache';

            self::$instance = new BladeOne($views, $cache, BladeOne::MODE_AUTO);
        }

        return self::$instance;
    }

    /**
     * Render a Blade view
     * Description: This method is used to render a Blade view.
     *
     * @param string $view
     * @param array $data
     * @return string
     * @throws Exception
     */
    public static function render($view, $data = []) {
        $useOutputBuffering = !ini_get('zlib.output_compression');

        if ($useOutputBuffering) {
            ob_start(); // Start output buffering if zlib compression is not enabled
        }

        try {
            $output = self::getInstance()->run($view, $data);
        } catch (Exception $e) {
            // Handle the exception (logging or rendering a fallback view)
            self::log('error', 'View Rendering Error', $e->getMessage());
            $output = self::fallbackView($e->getMessage());
        }

        if ($useOutputBuffering) {
            $output = ob_get_clean(); // Get and clean the buffer if output buffering was used
        }

        return $output;
    }
}
