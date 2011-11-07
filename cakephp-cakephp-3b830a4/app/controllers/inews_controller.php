<?php
class InewsController extends AppController { 
	var $name = 'Inews';

	var $coomponents = array('RequestHandler');
	var $helpers = array('Text');

	function index() {
		if(isset($this->passedArgs['Inews.id'])) {
				
		}

		$this->paginate = array(
                        'limit' => 10,
                        'order' => array(
                                'Inews.sid' => 'asc',
                                'Inews.thread' => 'asc'
                        )
                );

                $data = $this->paginate('Inews');
                $this->set('cates', $data);

		$data = '';	
		App::import('Component','Simplepie');     // load it
		if(!isset($this->Simplepie)) {
			$this->Simplepie = new SimplepieComponent();
			$this->Simplepie->startup($this);
			#$items = $this->Simplepie->feed('http://feeds.feedburner.com/TheGeekStuff');
			if(isset($this->passedArgs['Inews.id'])) {
				$data 		 = $this->Inews->find(array('id'=>$this->passedArgs['Inews.id']));
				$items 		 = $this->Simplepie->feed($data['Inews']['site_address']);
				$site 		 = $this->Simplepie->get_site();
				$siteLink 	 = $this->Simplepie->get_siteLink();
				$siteDescription = $this->Simplepie->get_siteDescription();
				$this->Inews->id = $this->passedArgs['Inews.id'];
				$data['Inews']['site'] = $site;
				$data['Inews']['site_address'] = $siteLink;
				$this->Inews->save($data);
			} else {
				$items 		 = $this->Simplepie->feed('http://media.daum.net/rss/part/primary/politics/rss2.xml');
				$site 		 = $this->Simplepie->get_site();
				$siteLink 	 = $this->Simplepie->get_siteLink();
				$siteDescription = $this->Simplepie->get_siteDescription();
			}

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
