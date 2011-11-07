<?php
class InewsController extends AppController { 
	var $name = 'Inews';

	var $coomponents = array('RequestHandler');
	var $helpers = array('Text');

	function index() {

		$site_group = '';
		$conditions = array();
		if(isset($this->passedArgs['Inews.name'])) {
			$conditions['Inews.site_group like '] = $this->passedArgs['Inews.name'].'%';	
		}
		if(isset($this->passedArgs['Inews.id'])) {
			$data = $this->Inews->find(array('id'=>$this->passedArgs['Inews.id']));
			$site_group = $data['Inews']['site_group'];
		}

		$this->paginate = array(
                        'limit' => 30,
                        'order' => array(
                                'Inews.sid' => 'asc',
                                'Inews.thread' => 'asc'
                        )
                );
		
                $data = $this->paginate('Inews',$conditions);
                $this->set('cates', $data);

		$data = '';	
		App::import('Component','Simplepie');     // load it
		if(!isset($this->Simplepie)) {
			$this->Simplepie = new SimplepieComponent();
			$this->Simplepie->startup($this);
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
			} else { // Default.
				$items 		 = $this->Simplepie->feed('http://media.daum.net/rss/part/primary/politics/rss2.xml');
				$site 		 = $this->Simplepie->get_site();
				$siteLink 	 = $this->Simplepie->get_siteLink();
				$siteDescription = $this->Simplepie->get_siteDescription();
				$site_group 	 = 'daum';
			}

			$site = $this->Simplepie->get_site();
			$siteLink = $this->Simplepie->get_siteLink();
			$siteDescription = $this->Simplepie->get_siteDescription();
			$this->set('sitGroup', $site_group);
			$this->set('site',$site);
			$this->set('siteLink', $siteLink);
			$this->set('siteDescription',$siteDescription);
			$this->set('feeds', $items);
		}
	}
}
?>
