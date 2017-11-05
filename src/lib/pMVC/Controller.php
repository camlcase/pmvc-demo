<?php
/**
 * The abstract controller class is the base class for all controllers.
 * It will set a default view and have a method to set a model. The 
 * constructor sets a default view to: /views/MODEL_BASE_NAME/ACTION_NAME.
 */
abstract class Controller
{
    /**
     * Holds the view
     * 
     * @var mixed
     */
	protected $view;
    
	/**
	 * Holds the controller
    * 
	 * @var mixed
	 */
	private $_controller;
    
	/**
	 * Holds the action
    * 
	 * @var mixed
	 */
	private $_action;
	
	/**
	 * Constructor. Sets the default view.
    * 
    * @param string $controller
	 * @param string $action
    * @return void
	 */
	public function __construct($controller, $action)
	{        
		$this->_action = $action;
		$this->_controller = $controller;
		
        // Bind view
        $this->setView($action);
	}
	
	/**
	 * Sets the view.
    * 
	 * @param string $viewName The name of the view
	 */
	protected function setView($view)
	{
		$this->view = new View('Views/' . $this->_controller . '/' . ucwords($view) . '.phtml');
	}
}