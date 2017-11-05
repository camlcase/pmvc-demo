<?php
/**
 * The Database class is a wrapper for PDO, 
 * implemented as a singleton.
 */
class Database
{
    /**
     * The PDO database object
     * 
     * @var PDO
     */
    private static $instance;

	/**
	 *  
	 */
    private function __construct() 
    {
		try {
			$dsn = sprintf('mysql:host=%s:%s;dbname=%s', DB_HOSTNAME, DB_PORT, DB_DATABASE);
			self::$instance = new PDO(
				$dsn, 
				DB_USERNAME, 
				DB_PASSWORD,
				array(
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
					PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'"
				)
			);
		} catch (PDOException $e) {
			die('Connection error: ' . $e->getMessage());
		}
    }

	public static function getInstance()
	{
		if (!self::$instance) {
			new Database();
		}
		return self::$instance;
	}
}