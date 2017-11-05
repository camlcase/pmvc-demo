<?php
/**
 * Represents support for rendering HTML controls in a view.
 */
class Html
{
    private function __construct() { }
    
    /**
     * Renders an hyperlink with a href to the supplied 
	 * controller and action.
     * 
     * @param string $linkText
     * @param string $controller
     * @param string $action (optional)
	 * @param array $routeValues (optional)
     * @param array $htmlAttributes (optional)
     * @return void
     */
    public static function actionLink($linkText, $controller, $action = 'index', $routeValues = null, $htmlAttributes = null)
    {
        $doc = new DOMDocument('1.0', 'utf-8');
        $a = $doc->createElement('a', $linkText);

        $a->setAttribute('href', Url::createPath($controller, $action, $routeValues));
        
		if ($htmlAttributes != null) {
			foreach ($htmlAttributes as $key => $val) {
				$a->setattribute($key, $val);
			}
		}
        
        $doc->appendChild($a);
        echo $doc->saveHTML();
    }
    
    /**
     * Creates a menu item. It will render an hyperlink (a) inside 
     * a list (li). The class 'active' will be added to the list 
     * element if the current controller matches the supplied controller.
     * 
     * @param string $text
     * @param string $controller
     * @param string $action (optional)
	 * @param array $routeValues (optional)
     */
    public static function menuItem($text, $controller, $action = 'index', $routeValues = null)
    {
        $doc = new DOMDocument('1.0', 'utf-8');
        $li = $doc->createElement('li');

        $liClass = 'nav-item';
        if (strtolower(Url::currentController()) === strtolower($controller)) {
            $liClass .= ' active';
        }
        $li->setAttribute('class', $liClass);
        
        $a = $doc->createElement('a', $text);
        $a->setAttribute('href', Url::createPath($controller, $action, $routeValues));
        $a->setAttribute('class', 'nav-link');
        $li->appendChild($a);
        
        $doc->appendChild($li);
        echo $doc->saveHTML();
    }
}