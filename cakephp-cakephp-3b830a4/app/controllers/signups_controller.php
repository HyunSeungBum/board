<?php
/**
	* (Sample) Controller for Showing the use of Captcha*
	* @author     Arvind K. Thakur
	* @link       http://www.devarticles.in/
	* @copyright  Copyright © 2008 www.devarticles.in
	* @version Tested ok in Cakephp 1.2+ & 1.3.7
	*/
class SignupsController extends AppController {

	var $name = 'Signups';
	var $uses = array('Signup');
	var $helpers = array('Html', 'Form', 'Ajax');
	var $components = array();

	function captcha()	{
		$this->autoRender = false;
		$this->layout='ajax';
		if(!isset($this->Captcha))	{ //if Component was not loaded throug $components array()
			App::import('Component','Captcha'); //load it
			$this->Captcha = new CaptchaComponent(); //make instance
			$this->Captcha->startup($this); //and do some manually calling
		}
		//$width = isset($_GET['width']) ? $_GET['width'] : '120';
		//$height = isset($_GET['height']) ? $_GET['height'] : '40';
		//$characters = isset($_GET['characters']) && $_GET['characters'] > 1 ? $_GET['characters'] : '6';
		//$this->Captcha->create($width, $height, $characters); //options, default are 120, 40, 6.
		$this->Captcha->create();
	}

	function add()	{
		if(!empty($this->data))	{

			if(!isset($this->Captcha))	{ //if Component was not loaded throug $components array()
				App::import('Component','Captcha'); //load it
				$this->Captcha = new CaptchaComponent(); //make instance
				$this->Captcha->startup($this); //and do some manually calling
			}

			$this->Signup->setCaptcha($this->Captcha->getVerCode()); //getting from component and passing to model to make proper validation checks
			if($this->Signup->save($this->data))	{ //as usual data save call
				// validation passed, do something
				pr("Captcha code validated!");
			}	else	{ //or
				pr("Error occured while matching captcha code!");
				//pr($this->Signup->validationErrors);
				//something do something else
			}
		}
	}
}