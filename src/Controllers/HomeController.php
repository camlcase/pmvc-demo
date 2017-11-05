<?php
class HomeController extends Controller
{
	public function init()
	{
		// Set page title
		$this->view->title = 'Start';
	}

	public function index()
	{
		// Renders the home view (Views/Home/Index.phtml)
		$this->view->render();
	}
}