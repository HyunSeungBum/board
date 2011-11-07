<?php
class InewsController extends AppController { 
	var $name = 'Inews';

	var $coomponents = array('RequestHandler');
	var $helpers = array('Text');

	function index() {
		App::import('Component','Simplepie');     // load it
		if(!isset($this->Simplepie)) {
			$this->Simplepie = new SimplepieComponent();
			$this->Simplepie->startup($this);
			$items = $this->Simplepie->feed('http://feeds.feedburner.com/TheGeekStuff');
			$site = $this->Simplepie->get_site();
			$siteLink = $this->Simplepie->get_siteLink();
			$siteDescription = $this->Simplepie->get_siteDescription();
			$this->set('site',$site);
			$this->set('siteLink', $siteLink);
			$this->set('siteDescription',$siteDescription);
			$this->set('feeds', $items);
		}
	}
}
?>
