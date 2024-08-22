<?php
namespace Hubrix\Middleware;

class ThrottleRequests {
    protected $maxAttempts;
    protected $decayMinutes;

    public function __construct() {
        // Load the configuration from routes.php
        $config = include HUBRIX_ROOT_DIR . 'config/routes.php';

        $this->maxAttempts = $config['throttle']['maxAttempts'] ?? 60;
        $this->decayMinutes = $config['throttle']['decayMinutes'] ?? 1;
    }

    public function handle() {
        $key = $this->resolveRequestSignature();
        $attempts = $this->getAttempts($key);

        if ($attempts >= $this->maxAttempts) {
            $this->sendThrottleResponse();
        }

        $this->incrementAttempts($key);
    }

    protected function resolveRequestSignature() {
        return sha1($_SERVER['REMOTE_ADDR'] . $_SERVER['REQUEST_URI']);
    }

    protected function getAttempts($key) {
        return get_transient($key) ?: 0;
    }

    protected function incrementAttempts($key) {
        $attempts = $this->getAttempts($key) + 1;
        set_transient($key, $attempts, $this->decayMinutes * MINUTE_IN_SECONDS);
    }

    protected function sendThrottleResponse() {
        header('HTTP/1.1 429 Too Many Requests');
        echo 'Too many requests, please slow down.';
        exit;
    }
}