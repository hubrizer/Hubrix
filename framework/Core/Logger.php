<?php

namespace Hubrix\Core;

class Logger {
    private static $config;

    private static $logLevels = ['DEBUG' => 1, 'INFO' => 2, 'WARNING' => 3, 'ERROR' => 4];

    private static function loadConfig() {
        if (self::$config === null) {
            // Adjust the path to locate the config file in the plugin's root directory
            $configPath = HUBRIX_ROOT_DIR . 'config/log.php';
            if (file_exists($configPath)) {
                self::$config = include $configPath;
            } else {
                error_log('Logger configuration file not found: ' . $configPath);
                self::$config = [
                    'log_is_enabled' => false,
                ]; // Default to logging disabled
            }
        }
    }

    public static function log($level, $message, $context = []) {
        self::loadConfig();

        // Check if logging is enabled
        if (!isset(self::$config['log_is_enabled']) || !self::$config['log_is_enabled']) {
            return;
        }

        // Check if the log level and config log level are set
        if (
            isset(self::$logLevels[$level]) &&
            isset(self::$config['log_level']) &&
            self::$logLevels[$level] >= (self::$logLevels[self::$config['log_level']] ?? PHP_INT_MAX)
        ) {
            $formattedMessage = self::formatMessage($level, $message, $context);
            self::writeLog($formattedMessage);
        } else {
            error_log("Invalid log level: " . print_r($level, true));
        }
    }

    private static function formatMessage($level, $message, $context) {
        $replacements = [
            '%datetime%' => date('Y-m-d H:i:s'),
            '%level_name%' => $level,
            '%message%' => $message,
        ];

        foreach ($context as $key => $value) {
            $replacements["%$key%"] = $value;
        }

        return strtr(self::$config['log_format'], $replacements);
    }

    private static function writeLog($message) {
        $logDir = HUBRIX_ROOT_DIR . 'storage/logs/';
        if (!file_exists($logDir)) {
            mkdir($logDir, 0755, true);
        }

        $logFile = $logDir . self::getLogFileName();
        file_put_contents($logFile, $message . PHP_EOL, FILE_APPEND);
    }

    private static function getLogFileName() {
        self::loadConfig();
        $baseFilename = self::$config['log_file'];

        if (self::$config['log_rotate']) {
            $date = date('Y-m-d');
            return str_replace('.log', '', $baseFilename) . "-$date.log";
        }

        return $baseFilename;
    }
}
