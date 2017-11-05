<?php
/**
 * The abstract model class is the base class for models.
 * It provides a small sets of functions for data access.
 */
abstract class Model
{
    /**
     * The PDO database object
     * 
     * @var PDO
     */
    private $_db;

    /**
     * The PDO statement
     * 
     * @var PDOStatement
     */
    private $_stmt;
    
    /**
     * Sets the database instance.
     * 
     * @return void
     */
    public function __construct()
    {
		$this->_db = Database::getInstance();
    }

	/**
	 * Prepares the supplied SQL query.
	 *
	 * @param string $query The SQL query.
	 * @return $this
	 */
    public function query($query) 
	{
        $this->stmt = $this->_db->prepare($query);
        return $this;
    }

	/**
	 * Binds a value to a corresponding named or question mark placeholder.
	 *
	 * @param mixed $parameter Parameter identifier.
	 * @param mixed $value The value to bind to the parameter.
	 * @param int $dataType Explicit data type for the parameter using the PDO::PARAM_* constants.
	 * @return $this
	 */
    public function bind($parameter, $value, $dataType = null) 
	{
        if ($dataType === null) {
            switch(true) {
                case is_int($value):
                    $dataType = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $dataType = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $dataType = PDO::PARAM_NULL;
                    break;
                default:
                    $dataType = PDO::PARAM_STR;
            }
        }

        $this->stmt->bindValue($parameter, $value, $dataType);
        return $this;
    }

	/**
	 * Executes the prepared statement.
	 */
    public function execute() 
	{
        return $this->stmt->execute();
    }

	/**
	 * Executes the prepared statement and fetches all of the 
	 * remaining rows in the result set.
	 *
	 * @return Array
	 */
    public function resultset() 
	{
        $this->execute();
        return $this->stmt->fetchAll();
    }

	/**
	 * Executes the prepared statement and fetches a single row 
	 * from result set.
	 */
    public function single() 
	{
        $this->execute();
        return $this->stmt->fetch();
    }
}