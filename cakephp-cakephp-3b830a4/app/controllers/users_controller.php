<?php 
	class UsersController extends AppController {
		var $name = 'Users';
		
		var $helpers = array('Form', 'Html');
		
		function index() {

		}
	
		function register() {
			if (!empty($this->data)) {
				if ($this->User->save($this->data)) {
					// Success 
					$this->redirect('/users/login/');
				} else {
					$this->set('errors', $this->User->invalidFields());
				}
			}
		}
		
		function ajax_check_username() {
			$this->layout = 'ajax';

			if (!empty($this->data)) {
				if ($this->data['User']['username'] == '') {
					$this->set('value', 0);
				} else {
					$u = $this->User->findByUsername($this->data['User']['username']);
					if (empty($u)) {
						$this->set('value', 1);
					} else {
						$this->set('value', 0);
					}
				}
			} else {
				$this->set('value', 0);
			}
		}
	}
?>