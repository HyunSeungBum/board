<?php
class TipController extends AppController {
	var $name = 'Tip';
	var $uses = array('Tip', 'Tips_comment');
	var $components = array('Cookie','RequestHandler');

	function captcha()	{
		$this->autoRender = false;
		$this->layout='ajax';
		if(!isset($this->Captcha))	{ 		// if Component was not loaded throug $components array()
			App::import('Component','Captcha'); 	// load it
			$this->Captcha = new CaptchaComponent();// make instance
			$this->Captcha->startup($this); 	// and do some manually calling
		}
		/*
		$width = isset($_GET['width']) ? $_GET['width'] : '120';
		$height = isset($_GET['height']) ? $_GET['height'] : '40';
		$characters = isset($_GET['characters']) && $_GET['characters'] > 1 ? $_GET['characters'] : '6';
		$this->Captcha->create($width, $height, $characters); //options, default are 120, 40, 6.
														*/
		$this->Captcha->create();
	}
	
	function index() {
	
		$conditions=Array();
		
		# paging.
		$this->paginate = array(
			'limit' => 15, 
			'order' => array(
				'Tip.sid' => 'desc',
				'Tip.thread' => 'asc'
			)
		);
		
		$data = $this->paginate('Tip', $conditions);
		
		$this->set('cateTitle', 'Tip');
		$this->set('tips', $data);
		
	}
	
	function checkcaptcha($captchaID=Null) {
		$this->autoRender = false;
		$this->layout='ajax';
		
		if(!isset($this->Captcha))	{ //if Component was not loaded throug $components array()
			App::import('Component','Captcha'); //load it
			$this->Captcha = new CaptchaComponent(); //make instance
			$this->Captcha->startup($this); //and do some manually calling
		}
		
		if($this->Captcha->getVerCode() != trim($_POST['captchaID'])) {
			$message=json_encode('false');
		} else {
			$message=json_encode('true');
		}	
		
		echo $message;
		
	}
	
	function checkpasswd() {
		$this->autoRender = false;
		$this->layout='ajax';
		
		if (!empty($_POST['id']) and !empty($_POST['password'])) {
			$this->data = $this->Tip->find(array('id'=>$_POST['id']));
		
			if ($this->data['Tip']['secure'] == $_POST['password']) {
				$message=json_encode('true');
			} else {
				$message=json_encode('false');
			}
			
			echo $message;
		}
	
	}
	
	function add() {
		if(!empty($this->data)) {
			
			if(!isset($this->Captcha))	{ //if Component was not loaded throug $components array()
				App::import('Component','Captcha'); //load it
				$this->Captcha = new CaptchaComponent(); //make instance
				$this->Captcha->startup($this); //and do some manually calling
			}
			
			if($this->Captcha->getVerCode() != trim($this->data['Tip']['captcha'])) {
				$this->redirect($this->referer());
			}
			
			$result = $this->Tip->find('all', array('fields'=>array('(MAX(sid)+1) as newsid')));
			if ($result[0][0]['newsid'] === NULL ) {
				$this->data['Tip']['sid']=1;
			} else {
				$this->data['Tip']['sid']=$result[0][0]['newsid'];
			}
			$this->data['Tip']['writer']='test';
			$this->data['Tip']['ip_addr'] = $_SERVER['REMOTE_ADDR'];
			$this->data['Tip']['wdate']=strtotime('now');
			if($this->Tip->save($this->data)) {
				$this->Session->setFlash('The ServerInfo has been saved');
				$this->redirect(array('action'=>'index'), null, true);
			} else {
				$this->Session->setFlash('The ServerInfo could not be saved. Please, try again.');
			}
		}
	}
	
	function view($id=null) {
		if(empty($this->data)) {
			# read count setcookie
			$cookiename='tips_'.$id;
			if(!$this->Cookie->read($cookiename)) {
					$this->Cookie->write($cookiename,'read_'.$id, false);
					$result = $this->Tip->query("UPDATE tips SET rcount = rcount+1 WHERE id= ".$id." LIMIT 1");
			}
			$this->data = $this->Tip->find(array('id'=>$id));
			$this->set('Tips', $this->data['Tip']);
			
			# comment
			$comment = $this->Tips_comment->find('all', array(
				'conditions' => array('Tips_comment.sid' => $id),
				'order' => array('Tips_comment.thread DESC')));
			
			$this->set('Comments', $comment);
			$this->set('rcount', count($comment));
			$this->set('page', $this->params['named']['page']);
		} 
	}
	
	function edit($id=null) {
	
		if(!$id) {
			$this->Session->setFlash('Invalid Id');
			$this->redirect($this->referer());
		}
		
		if(empty($this->data)) {
			$this->data = $this->Tip->find(array('id'=>$id));
			$this->set('Tips', $this->data['Tip']);
			$this->set('page', $this->params['named']['page']);
		} else {
			$page = $this->data['Tip']['page'];
			unset($this->data['Tip']['page']);
			$secure = $this->data['Tip']['secure'];
			$data = $this->Tip->find(array('id'=>$id));
			if ($data['Tip']['secure'] == trim($secure)) {
				$this->Tip->id = $id;
				if($this->Tip->save($this->data)) {
					$this->Session->setFlash('The ServerInfo has been saved');
					$this->redirect('/tip/view/'.$id.'/page:'.$page);
				} else {
					$this->Session->setFlash('The ServerInfo could not be saved. Please, try again.');
					$this->redirect($this->referer());
				}
			} else {
				$this->Session->setFlash('password not invalid');
				$this->redirect($this->referer());
			}
		}
	}
	
	function reply($id=null) {
		if(empty($this->data)) {
			$this->data = $this->Tip->find(array('id'=>$id));
			$this->set('Tips', $this->data['Tip']);
			$this->set('page', $this->params['named']['page']);
		# post data 
		} else { 
			$maxThreadRecord = $this->Tip->find('first', array(
				'order' => 'Tip.thread DESC',
				'conditions' => array('Tip.sid'=>$this->data['Tip']['sid'])
			));
			$maxThread = $maxThreadRecord['Tip']['thread'];
			$postThread = $this->data['Tip']['thread'];
			if ($postThread == $maxThread) {
				# insert data
				$page = $this->data['Tip']['page'];
				unset($this->data['Tip']['page']);
				$this->data['Tip']['thread'] = $postThread +1;
				$this->data['Tip']['writer']='test';
				$this->data['Tip']['ip_addr'] = $_SERVER['REMOTE_ADDR'];
				$this->data['Tip']['wdate']=strtotime('now');
				unset($this->data['Tip']['id']);	
				if($this->Tip->save($this->data)) {
					$this->Session->setFlash('The ServerInfo has been saved');
					$this->redirect('/tip/index/page:'.$page);
				} else {
					$this->Session->setFlash('The ServerInfo could not be saved. Please, try again.');
				}

			} else {
				$this->Tip->updateAll(
					array('Tip.thread'  => 'Tip.thread+1'),
					array('Tip.thread >'=> $postThread, 'Tip.sid' => $this->data['Tip']['sid'])
				);
				# insert data
				$page = $this->data['Tip']['page'];
				unset($this->data['Tip']['page']);
				$this->data['Tip']['thread'] = $postThread +1;
				$this->data['Tip']['writer']='test';
				$this->data['Tip']['ip_addr'] = $_SERVER['REMOTE_ADDR'];
				$this->data['Tip']['wdate']=strtotime('now');
				unset($this->data['Tip']['id']);	
				if($this->Tip->save($this->data)) {
					$this->Session->setFlash('The ServerInfo has been saved');
					$this->redirect('/tip/index/page:'.$page);
				} else {
					$this->Session->setFlash('The ServerInfo could not be saved. Please, try again.');
				}
			}
		}
	}
	
	function deletememo($id) {
		$secure = $this->data['Tips_delete']['secure'];
		$this->data = $this->Tip->find(array('id'=>$id));
		if ($this->data['Tip']['secure'] == trim($secure)) {
			$this->Tip->delete($id);
			$this->Session->setFlash('The post with id: '.$id.' has been deleted.');
			$this->redirect('/tip/index/page:'.$this->params['named']['page']);
		} else { 
			$this->Session->setFlash('password not invalid'); 
			$this->redirect($this->referer());
		}
	}
	
	function addcomment() {
		if(!empty($this->data)) {
			$conditions = array("Tips_comment.sid" => $this->data['Tips_comment']['id']);
			$result = $this->Tips_comment->find('all', array('fields'=>array('MAX(thread) as thread')), array('conditions' => $conditions));
			if ($result[0][0]['thread'] === NULL) {
				$this->data['Tips_comment']['thread'] = 1;
			} else {
				$this->data['Tips_comment']['thread'] = $result[0][0]['thread'] + 1;
			}
			$this->data['Tips_comment']['sid'] = $this->data['Tips_comment']['id'];
			$this->data['Tips_comment']['ip_addr'] = $_SERVER['REMOTE_ADDR'];
			$this->data['Tips_comment']['wdate']=strtotime('now');
			unset($this->data['Tips_comment']['id']);
			if($this->Tips_comment->save($this->data)) {
				$this->Session->setFlash('The ServerInfo has been saved');
				$this->redirect(array('action'=>'index'), null, true);
			} else {
				$this->Session->setFlash('The ServerInfo could not be saved. Please, try again.');
			}
		}
	}
}
?>
