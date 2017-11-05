<?php
/**
 * The view class loads a specific view file (.phtml) and site template 
 * view into an internal buffer. The view data array will be extracted 
 * into the current symbol table and available in the view.
 */
class View
{        
    /**
     * The view file
     * 
     * @var string
     */
    private $_file;
    
    /**
     * The data array that is available in the template view
     * 
     * @var array
     */
    private $_data = array();
    
    /**
     * The name of the body content variable
     * 
     * @var string
     */
    private $_bodyKey = 'BODY';
    
    /**
     * Initializes a new instance of the View class.
     * 
     * @param string $file
     * @return void
     */
    public function __construct($file)
    {
        $this->_file = $file;
    }
    
    /**
     * Pushes the supplied value into the data view array using the 
     * specified index key.
     * 
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function setVariable($key, $value)
    {
        if ($key != $this->_bodyKey) {
            $this->_data[$key] = $value;
        }
    }
    
    /**
     * Pushes the supplied array of key-value-pairs into the data view 
     * array.
     * 
     * @param array $array
     * @return void
     */
    public function setVariables(array $array)
    {
        foreach ($array as $key => $value) {
            if ($key != $this->_bodyKey) {
                $this->_data[$key] = $value;
            }
        }
    }

    /**
     * Render the view.
     * 
     * @return void
     */
    public function render()
    {
        echo $this->getContent();
    }
    
    /**
     * Put everything together in the buffer and returns the final content.
     * 
     * @return string
     */
    private function getContent()
    {        
        try {
            if (!file_exists($this->_file)) {
                throw new Exception("The template file {$this->_file} doesn´t exist.");
            }

            // Start output buffering
            ob_start();

            // Extract the data array into current symbol table
            extract($this->_data);
        
            // Includes the specified view file
            include $this->_file;
        
            // Push all content of the view into the body variable and 
            // extract it to the symbol table. This variable is isolated 
            // from the included view itself and will not be available.
            extract(array(
                $this->_bodyKey => ob_get_clean()
            ));

            // Get the main site layout defined in the config.php file
            include LAYOUT;
        
            // Gets current buffer contents and delete current output buffer.  
            // Writes the final content to te client.
            // Note: ob_get_clean() essentially executes both ob_get_contents() and ob_end_clean().
            return ob_get_clean();
        } catch (Exception $ex) {
            ob_end_clean();
            throw $ex;
        }
    }
}