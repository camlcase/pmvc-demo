<?php
class Search extends Model
{
	public function __construct()
	{
		parent::__construct();
   }

	/**
	 * Search news using the supplied query.
	 */
	public function find($query)
	{
		return $this
			->query("SELECT ID, DATE_FORMAT(date, '%Y-%m-%d') AS date, title, content, thumbnail, name FROM news WHERE title LIKE :query OR content LIKE :query")
			// Always bind you SQL parameters to avoid SQL injections! 
			->bind(':query', "%$query%", PDO::PARAM_STR)
			->resultset();
	}
}