<?php

declare(strict_types=1);

use Phalcon\Di\FactoryDefault;

error_reporting(E_ALL);

define('DS', DIRECTORY_SEPARATOR);
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

try {

    /**
     * Register the Composer autoloader (if any)
     */
    $vendorAutoload = [
        __DIR__ . DS . '..' . DS . '..' . DS . '..' . DS . 'vendor' . DS . 'autoload.php',
        __DIR__ . DS . '..' . DS . '..' . DS . 'vendor' . DS . 'autoload.php',
        __DIR__ . DS . '..' . DS . 'vendor' . DS . 'autoload.php',
        __DIR__ . DS . 'vendor' . DS . 'autoload.php',
    ];

    foreach ($vendorAutoload as $file) {
        if (file_exists($file)) {
            require $file;
            break;
        }
    }

    /**
     * The FactoryDefault Dependency Injector automatically registers
     * the services that provide a full stack framework.
     */
    $di = new FactoryDefault();

    /**
     * Read services
     */
    include APP_PATH . '/config/services.php';

    /**
     * Handle routes
     */
    include APP_PATH . '/config/router.php';

    /**
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    /**
     * Include Autoloader
     */
    include APP_PATH . '/config/loader.php';

    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);

    echo $application->handle($_SERVER['REQUEST_URI'])->getContent();
} catch (\Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
