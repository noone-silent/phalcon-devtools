<?php
declare(strict_types=1);

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Micro;

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
     * The FactoryDefault Dependency Injector automatically registers the services that
     * provide a full stack framework. These default services can be overidden with custom ones.
     */
    $di = new FactoryDefault();

    /**
     * Include Services
     */
    include APP_PATH . '/config/services.php';

    /**
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    /**
     * Include Autoloader
     */
    include APP_PATH . '/config/loader.php';

    /**
     * Starting the application
     * Assign service locator to the application
     */
    $app = new Micro($di);

    /**
     * Include Application
     */
    include APP_PATH . '/app.php';

    /**
     * Handle the request
     */
    $app->handle($_SERVER['REQUEST_URI']);
} catch (\Exception $e) {
      echo $e->getMessage() . '<br>';
      echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
