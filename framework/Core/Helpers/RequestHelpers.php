<?php
namespace Hubrix\Core\Helpers;

class RequestHelpers
{
    protected $data;

    public function __construct()
    {
        $this->data = array_merge($_GET, $_POST);
    }

    public function get($key = null, $default = null)
    {
        if ($key === null) {
            return $this->data;
        }

        return $this->data[$key] ?? $default;
    }

    public function post($key = null, $default = null)
    {
        if ($key === null) {
            return $_POST;
        }

        return $_POST[$key] ?? $default;
    }

    public function query($key = null, $default = null)
    {
        if ($key === null) {
            return $_GET;
        }

        return $_GET[$key] ?? $default;
    }

    public function input($key, $default = null)
    {
        return $this->get($key, $default);
    }

    public function has($key)
    {
        return isset($this->data[$key]);
    }

    public function all()
    {
        return $this->data;
    }

    public function only(array $keys)
    {
        return array_intersect_key($this->data, array_flip($keys));
    }

    public function except(array $keys)
    {
        return array_diff_key($this->data, array_flip($keys));
    }

    public function method()
    {
        return $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }

    public function isMethod($method)
    {
        return strtoupper($this->method()) === strtoupper($method);
    }

    public function ajax()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    public function ip()
    {
        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }

    public function header($key, $default = null)
    {
        $key = 'HTTP_' . strtoupper(str_replace('-', '_', $key));
        return $_SERVER[$key] ?? $default;
    }
}
