<?php
class SearchController extends Controller
{
  public function init()
  {
    // Set page title
    $this->view->title = 'Search';
  }

  public function index()
  {
    // Gets the query search term from the url
    $this->view->searchTerm = $_GET['q'] ?? '';

    if (!empty($this->view->searchTerm)) {
      // Creates a new search model which will search for news in database
      $search = new Search();

      // Makes search result available in the search view
      $this->view->result = $search->find($this->view->searchTerm);
      $this->view->hits = count($this->view->result);

      // Will highlight the search term in
      $this->highlight();
    }

    // Renders the search view (Views/Search/Index.phtml)
    $this->view->render();
  }

  /**
   * Highlight words in search result using the current search term.
   * The search term will be surrounded by a span html tag with a css
   * class defined, so it can be controlled by the CSS site styles.
   */
  private function highlight()
  {
    $searchTerm = preg_quote($this->view->searchTerm, '/');
    $regex = "/\b({$this->view->searchTerm})\b/i";
    $replaceStr = '<span class="highlight">$1</span>';

    foreach ($this->view->result as &$news) {
      // Highligt search term in news title
      $news['title'] = preg_replace($regex, 
        $replaceStr, $news['title']);

      // Highlight search term in news content
      $news['content'] = preg_replace($regex, 
        $replaceStr, $news['content']);
    }
  }
}