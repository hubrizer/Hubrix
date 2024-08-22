<?php
namespace Hubrix\Middleware;

class FilterRequests {
    protected $blacklist = [];
    protected $whitelist = [];

    public function __construct() {
        // Load the configuration from routes.php
        $config = include HUBRIX_ROOT_DIR . 'config/routes.php';

        $this->blacklist = $config['blacklist'] ?? [];
        $this->whitelist = $config['whitelist'] ?? [];
    }

    public function handle() {
        $ip = $_SERVER['REMOTE_ADDR'];

        // First, check if the IP is whitelisted
        if ($this->isIpInList($ip, $this->whitelist)) {
            return; // If whitelisted, bypass the blacklist
        }

        // Then, check if the IP is blacklisted
        if ($this->isIpInList($ip, $this->blacklist)) {
            $this->denyAccess('Your IP is blacklisted.');
        }
    }

    protected function isIpInList($ip, $list) {
        foreach ($list as $entry) {
            if ($this->ipMatchesEntry($ip, $entry)) {
                return true;
            }
        }
        return false;
    }

    protected function ipMatchesEntry($ip, $entry) {
        if (strpos($entry, '*') !== false) {
            // Wildcard: Convert to regex and match
            $pattern = str_replace('*', '.*', preg_quote($entry, '/'));
            return preg_match("/^{$pattern}$/", $ip);
        }

        if (strpos($entry, '-') !== false) {
            // Range: Convert to numeric comparison
            [$startIp, $endIp] = explode('-', $entry);
            return $this->ipInRange($ip, $startIp, $endIp);
        }

        // Exact match
        return $ip === $entry;
    }

    protected function ipInRange($ip, $startIp, $endIp) {
        // Convert the IPs to their long integer equivalents
        $ipLong = ip2long($ip);
        $startIpLong = ip2long($startIp);
        $endIpLong = ip2long($endIp);

        // Ensure the range is correctly ordered
        if ($startIpLong > $endIpLong) {
            [$startIpLong, $endIpLong] = [$endIpLong, $startIpLong];
        }

        return ($ipLong >= $startIpLong) && ($ipLong <= $endIpLong);
    }

    protected function denyAccess($message) {
        header('HTTP/1.1 403 Forbidden');
        echo $message;
        exit;
    }
}