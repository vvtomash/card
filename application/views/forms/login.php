<?=Form::open('login', ['class'=> 'form-signin', 'method' => 'post']);?>
	<h2 class="form-signin-heading">Войти на сайт</h2>
	<label for="inputEmail" class="sr-only">Email address</label>
	<?=Form::input('email', $email, [
		'id'=> 'inputEmail',
		'type' => 'email',
		'class' => 'form-control',
		'placeholder' => 'Введите email',
		'required' => 1,
		'autofocus' => 1,
		'autocomplete' => 'off',
	]);?>
	<label for="inputPassword" class="sr-only">Пароль</label>
	<?=Form::password('password', null, ['id'=> 'inputPassword', 'class' => 'form-control last', 'placeholder' => 'Введите пароль', 'required' => 1]);?>
	<? foreach($errors as $error) {?>
		<small class="alert-danger"><?=$error?></small>
	<?}?>
	<?=Form::submit('signup', 'Войти', ['class'=> 'btn btn-lg btn-primary btn-block']);?>
<?=Form::close();?>
