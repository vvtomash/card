<?=Form::open('signup', ['class'=> 'form-signup', 'method' => 'post']);?>
	<h2 class="form-signup-heading">Зарегистрируйтесь</h2>
	<label for="inputEmail" class="sr-only">Email address</label>
	<?=Form::input('email', $email, ['id'=> 'inputEmail', 'type' => 'email', 'class' => 'form-control', 'placeholder' => 'Введите email', 'required' => 1, 'autofocus' => 1]);?>
	<label for="inputPassword" class="sr-only">Пароль</label>
	<?=Form::password('password', null, ['id'=> 'inputPassword', 'class' => 'form-control', 'placeholder' => 'Введите пароль', 'required' => 1]);?>
	<label for="inputPasswordConfirm" class="sr-only">Подверждение пароля</label>
	<?=Form::password('password_confirm', null, ['id'=> 'inputPasswordConfirm', 'class' => 'form-control last', 'placeholder' => 'Подтвердите пароль', 'required' => 1]);?>
	<?=Form::submit('signup', 'Зарегистрироваться', ['class'=> 'btn btn-lg btn-primary btn-block']);?>
<?=Form::close();?>
