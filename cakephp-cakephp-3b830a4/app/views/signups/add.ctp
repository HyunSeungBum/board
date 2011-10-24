<?php 
	echo $form->create("Signups"); 
?>

<?php echo $html->image($html->url(array('controller'=>'signups', 'action'=>'captcha'), true),array('style'=>'','vspace'=>2, 'id'=>'captchaID')); ?>
<?php echo $ajax->link('Can not read this code?','re-generate captcha',array('url'=>'captcha','update'=>'captchaID','loading'=>'do this','loaded'=>'do that')); ?>
<p>Enter security code shown above:</p>
<?php
	echo $form->input('Signup.captcha',array('autocomplete'=>'off','label'=>false,'class'=>'','error'=>__('Failed validating code',true)));
?>

<?php echo $form->submit(__(' Submit ',true)); ?>

<?php echo $form->end(); ?>