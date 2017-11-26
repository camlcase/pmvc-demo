<?php
class News extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Returns all news.
	 */
	public function all()
	{
		return $this
			->query("SELECT ID, DATE_FORMAT(date, '%Y-%m-%d') AS date, title, content, thumbnail, name FROM news ORDER BY date DESC")
			->resultset();
	}

	/**
	 * Find news by name.
	 */
	public function find($name)
	{
		return $this
			->query("SELECT ID, DATE_FORMAT(date, '%Y-%m-%d') AS date, title, content, thumbnail, name FROM news WHERE name=:name")
			// Always bind SQL parameters to avoid SQL injections!
			->bind(':name', $name, PDO::PARAM_STR)
			->single();
	}
}