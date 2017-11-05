<?php
/**
 * The application class is the main class for a pMVC application.
 */
final class Application
{
    /**
     * pMVC version identification
     */
    const VERSION = '1.0.0';

    /**
     * Run application.
     *
     * @param IRoute $route
     */
    public static function run(IRoute $route = null)
    {
        // Include application configuration settings
        require_once 'config.php';

        // Autoload classes
        spl_autoload_register('Application::autoload');

        // If no custom route is supplied the
        // standard pMVC route will be used.
        if ($route == null) {
            $route = new Route();
        }

        // URL routing
        try {
            $route->map();
        } catch (Exception $ex) {
            echo 'Routing exception caught: ',  $ex->getMessage();
        }
    }

    /**
     * Autoloads a class using the supplied class name.
     * The class will only be autoloaded if it has
     * been defined, to reduce CPU.
     *
     * @param mixed $callable A valid PHP callable
     */
    private static function autoload($callable)
    {
        if (class_exists($callable, false)) {
            return;
        }

        $rootPath = dirname(dirname(__DIR__));

        // Define file paths
        $files = array(
            sprintf('%s/%s.php', __DIR__, $callable),               // app
            sprintf('%s/Models/%s.php', $rootPath, $callable),      // models
            sprintf('%s/Controllers/%s.php', $rootPath, $callable)  // controllers
        );

        // Include files
        foreach ($files as $file) {
            if (file_exists($file)) {
                include $file;
            }
        }
    }
}
