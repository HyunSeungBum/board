<?php

/*----------------------------
= Originservers Controller Class
-----------------------------*/
class OriginserversController extends AppController 
{

	var $name = 'Originservers';
	var $helpers = array('Html', 'Form');
	
	function search() {
		// the page we will redirect to
		$url['action'] = 'index';

		// build a URL will all the search elements in it
		// the resulting URL will be 
		// example.com/cake/posts/index/Search.keywords:mykeyword/Search.tag_id:3
		foreach ($this->data as $k=>$v){ 
			foreach ($v as $kk=>$vv){ 
				$url[$k.'.'.$kk]=$vv; 
			} 
		}

		// redirect the user to the url
		$this->redirect($url, null, true);

	
	}
	
	function index() 
	{
	
		// the elements from the url we set above are read  
		// automagically by cake into $this->passedArgs[]
		// eg:
		// $passedArgs['Search.keywords'] = mykeyword
		// $passedArgs['Search.tag_id'] = 3

		// required if you are using Containable
		// requires Post to have the Containable behaviour
		//$contain = array();  

		// we want to set a title containing all of the 
		// search criteria used (not required)		
		
		$conditions=Array();
		// filter category
		if(isset($this->passedArgs['Originservers.category'])) {
			if ($this->passedArgs['Originservers.category'] != 'all') {
				$conditions['Originserver.category like '] = $this->passedArgs['Originservers.category'].'%';
			}
		}
		
		// filter mode
		if(isset($this->passedArgs['Originservers.mode'])) {
			if ($this->passedArgs['Originservers.mode'] == 'domain') {
				$conditions['Originserver.domain like '] =  $this->passedArgs['Originservers.search'].'%';
			} 
			
			if ($this->passedArgs['Originservers.mode'] == 'ip') {
				$conditions['Originserver.ip like '] =  $this->passedArgs['Originservers.search'].'%';
			}
		}

		# paging.
		$this->paginate = array(
			'limit' => 30, 
			'order' => array(
				'Originserver.domain' => 'asc'
			)
		);

		$data = $this->paginate('Originserver', $conditions);
		
		$this->set('cateTitle', '목록');
		$this->set('originservers', $data);
	
	}
	
	function add() {
	
		if(!empty($this->data)) {
			$this->Originserver->create();
			if ($this->Originserver->save($this->data)) {
				$this->Session->setFlash('The Task has been saved');
				$this->redirect(array('action'=>'index'), null, true);
			} else {
				$this->Session->setFlash('Task not saved. Try again.');
			}
		}
	}
	
	function edit($id=null) {
		
		if(!$id) {
			$this->Session->setFlash('Invalid Id');
			$this->redirect(array('action'=>'index'), null, true);
		}
		
		if(empty($this->data)) {
			$this->data = $this->Originserver->find(array('id'=>$id));
			$this->set('originservers', $this->data['Originserver']);
		} else {
			if($this->Originserver->save($this->data)) {
				$this->Session->setFlash('The ServerInfo has been saved');
				$this->redirect(array('action'=>'index'), null, true);
			} else {
				$this->Session->setFlash('The ServerInfo could not be saved. Please, try again.');
			}
		}
	}
	
	function delete($id) {
		if($this->Originserver->delete($id)) {
			$this->Session->setFlash('The post with id: ' . $id . ' has been deleted.');
			$this->redirect(array('action' => 'index'));
		}
	}
	
}

?>
