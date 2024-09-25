<?php
namespace Hubrix\Core;

class ServiceProviderRegistry
{
    private static $loadedProviders = [];

    public static function load(string $providerClass): void
    {
        if (!in_array($providerClass, self::$loadedProviders)) {

            // Assuming the service provider class has a static method 'create' that returns an instance
            if (method_exists($providerClass, 'create')) {
                $provider = $providerClass::create();
            } else {
                $provider = new $providerClass();
            }

            //error_log("Checking if 'register' method exists in " . $providerClass);
            if (method_exists($provider, 'register')) {
                //error_log("Register method found in " . $providerClass);
                $provider->register();
            } else {
                error_log("The provider class $providerClass does not have a register method. Available methods: " . implode(', ', get_class_methods($provider)));
            }

            self::$loadedProviders[] = $providerClass;
        }
    }
}