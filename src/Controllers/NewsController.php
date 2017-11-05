<?php
class NewsController extends Controller
{
	public function init()
	{
		// Set page title
		$this->view->title = 'News';
	}

	public function index($name = null)
	{
		// Creates a new News data model that will communicate with database
		$news = new News();

		if ($name == null) {
			// Get all news and make them accessible by the view file. 
			// This is the initial state.
			$this->view->news = $news->all();
		} else {
			// Finds a single news by its friendly name
			$single = $news->find($name);
		
			// Renders the single news view (Views/News/News.phtml)
			$this->setView('News');

			// Make single news available in News.phtml
			$this->view->news = $single;
		}

		// Renders the news view: Views/News/Index.phtml or Views/News/News.phtml
		// depending on what view is defined.
		$this->view->render();
	}
}