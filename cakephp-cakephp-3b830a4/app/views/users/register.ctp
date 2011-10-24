<!-- <h1>Create an Account</h1><form action="/users/register" id="UserRegisterForm" method="post" accept-charset="utf-8"><div style="display:none;"><input type="hidden" name="_method" value="POST" /></div> //-->
<?php
	echo '<h1>Create an Account</h1>';
	echo $form->Create('User',array(
				'action'=>'register',
				'inputDefaults' => array(
					'div'=>false,
					'label'=>false
					),
				));

	if (isset($errors)) {
		$form->error = $errors;
	}
	echo '<fieldset>';
	echo '<legend>Create an Account</legend>';
	echo '<ol>';
	echo '<li><label for="Username">Username';
	if ($form->isFieldError('username')) {
		echo '<br/><strong>' .  $form->error('username') . '</strong>';
	}
	echo '</label>';
	echo $form->text('username');
	echo '<span class="ajax_status"><img src="/img/ajax-loader.gif" alt="Checking..." /></span>';
	echo '<span id="username_ajax_result"></span>';
	echo '</li>';
	echo '<li><label for="Email">Email';
	if ($form->isFieldError('email')) {
		echo '<br/><strong>' . $form->error('email') . '</strong>';
	}
	echo '</label>';
	echo $form->text('email');
	echo '</li>';
	echo '<li><label for="Password">Password';
	if ($form->isFieldError('password')) {
		echo '<br/><strong>' . $form->error('password') . '</strong>';
	}
	echo '</label>';
	echo $form->password('password');
	echo '</li>';
	echo '</ol>';
	echo '</fieldset>';
	echo $form->end('Submit');
?>