<?php
class ReadMoreController extends Controller
{
	public function init()
	{
		// Set page title
		$this->view->title = 'Read more';
	}

	public function index()
	{
		// Renders the read more view (Views/ReadMore/Index.phtml)
		$this->view->render();
	}
}