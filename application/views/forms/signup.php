<?=Form::open('signup', ['class'=> 'form-signup', 'method' => 'post']);?>
	<h2 class="form-signup-heading">Зарегистрируйтесь</h2>
	<div class="form-group <?=(!isset($errors['email']) ?: 'has-error')?>">
		<label for="inputEmail" class="sr-only">Email address ssss</label>
		<?= Form::input('email',
			$email,
			[
				'id'=> 'inputEmail',
				'type' => 'email',
				'class' => 'form-control',
				'placeholder' => 'Введите email',
				'required' => 1,
				'autofocus' => 1,
				'autocomplete' => 'off'
			]
		);?>
		<label for="inputPassword" class="sr-only">Пароль</label>
		<?=Form::password(
			'password', null,
			[
				'id'=> 'inputPassword',
				'class' => 'form-control',
				'placeholder' => 'Введите пароль',
				'required' => 1,
				'autocomplete' => 'off'
			]
		);?>
		<label for="inputPasswordConfirm" class="sr-only">Подверждение пароля</label>
		<?=Form::password(
			'password_confirm', null,
			[
				'id'=> 'inputPasswordConfirm',
				'class' => 'form-control last',
				'placeholder' => 'Подтвердите пароль',
				'required' => 1,
				'autocomplete' => 'off'
			]
		);?>
		<? foreach($errors as $error) {?>
			<small class="alert-danger"><?=$error?></small>
		<?}?>
		<?=Form::submit('signup', 'Зарегистрироваться', ['class'=> 'btn btn-lg btn-primary btn-block']);?>
	</div>
<?=Form::close();?>
