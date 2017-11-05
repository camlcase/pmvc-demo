<?php
/**
 * The Route class maps the current URL to a specific controller action.
 * It also provides the URL parameters if supplied.
 */
class Route implements IRoute
{
    // Initial values
    private $_controller = 'home';
    private $_action = 'index';
    private $_urlParams = array();

    /**
     * Maps the current request to a controller action.
     *
     * @return void
     */
    public function map()
    {
        // If the url variable is passed we parse URL.
        // Otherwise default values are used.
        if (isset($_GET['url'])) {
            $this->extractRouteParams();
        }

        // Creates a new controller object based on the supplied parameters
        $controllerName = $this->_controller;
        $this->_controller .= 'Controller';

        // Verify that controller exist
        if (!class_exists($this->_controller)) {
            throw new Exception('The controller requested doesn&#39;t exist. Please check URL.');
        }

        $controller = new $this->_controller($controllerName, $this->_action);

        // Execute the init() method of the controller if exists
        if (method_exists($controller, 'init')) {
            $controller->init();
        }

        // If exists invoke the method defined in the URL
        if (method_exists($controller, $this->_action)) {
            $controller->{$this->_action}($this->_urlParams);
        } else {
			// As a fallback use index method as action instead
			// and action variable as method parameters.
			// That will cover URLs like: domain.com/news/name-of-the-news
			$controller = new $this->_controller($controllerName, 'index');
			$controller->{'index'}($this->_action);
        }
    }

    /**
     * Extracts route parameters from current URL.
     *
     * @return void
     */
    private function extractRouteParams()
    {
        // Extract params
        $params = array_filter(explode('/', $_GET['url']));

        // First parameter is the controller
        $this->_controller = $params[0];

        // Second parameter is the action method
		if (isset($params[1]) && !empty($params[1])) {
			$this->_action = $params[1];
		}

        // Set additional parameters
		if (isset($params[2]) && !empty($params[2])) {
			$this->_urlParams = $params[2];
		}
    }
}
