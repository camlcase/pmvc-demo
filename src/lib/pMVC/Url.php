<?php
/**
 * Contains methods to build URLs for pMVC within an application.
 */
class Url
{
    private function __construct() { }
    
    /**
     * Creates a path using the supplied controller name
     * and action method name.
     * 
     * @param string $controller
     * @param string $action
     * @return string
     */
    public static function createPath($controller, $action, $routeValues = null)
    {
		if (!isset($controller) || trim($controller) === '') 
			return self::applicationUri();

		// Define action method
        $action = ($action == 'index') ? '' : $action;

		// Append route values
		$route = '';
		if ($routeValues != null) {
			foreach ($routeValues as $value) {
				$route .= $value . '/';
			}
		}

        return sprintf('%s/%s/%s%s', self::applicationUri(), $controller, $action, $route);
    }
    
    /**
     * Extracts the name of the current controller loaded, 
     * without the Controller suffix. This function searches 
     * the resulting array of the debug backtrace function.
     * 
     * @param bool $suffix
     * @return null|string
     */
    public static function currentController($suffix = false)
    {
        $traces = debug_backtrace();
        for ($i = 0; $i < count($traces); $i++) {
            $filePath = $traces[$i]['file'];
            $match = 'Controller.php';
            if (strpos($filePath, $match) > 0) {
                $needle = $suffix ? '.php' : $match;
                
                $endPos = strpos($filePath, $needle);
                $startPos = strrpos($filePath, '\\') + 1;
                $length = ($endPos - $startPos);
                
                $currentController = substr($filePath, $startPos, $length);
                
                return $currentController;
            }
        }
        return null;
    }
    
    /**
     * Converts a virtual (relative) path to an application absolute path.
     * 
     * @todo First call to this doesn´t work. Why?
     * @param string $contentPath
     */
    public static function content($contentPath)
    {
        echo sprintf('%s%s', self::applicationUri(), $contentPath);
    }
    
    /**
     * Returns the application Uri.
     * 
     * @return string
     */
    private static function applicationUri()
    {
        return defined('APPLICATION_URI') ? APPLICATION_URI : null;
    }
}