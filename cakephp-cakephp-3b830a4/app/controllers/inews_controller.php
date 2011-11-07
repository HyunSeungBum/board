<?php
class InewsController extends AppController { 
	var $name = 'Inews';

	var $coomponents = array('RequestHandler');
	var $helpers = array('Text');

	function index() {
		$this->set('cateTitle', 'IT News'); 
		App::import('Component','Simplepie');     // load it
		if(!isset($this->Simplepie)) {
			$this->Simplepie = new SimplepieComponent();
			$this->Simplepie->startup($this);
			$items = $this->Simplepie->feed('http://feeds.feedburner.com/TheGeekStuff');
			$this->set('feeds', $items);
		}
	}
}
?>
