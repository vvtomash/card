<?=Form::open('login', ['class'=> 'form-signin', 'method' => 'post']);?>
	<h2 class="form-signin-heading">Войти на сайт</h2>
	<label for="inputEmail" class="sr-only">Email address</label>
	<?=Form::input('email', '', ['id'=> 'inputEmail', 'type' => 'email', 'class' => 'form-control', 'placeholder' => 'Введите email', 'required' => 1, 'autofocus' => 1]);?>
	<label for="inputPassword" class="sr-only">Пароль</label>
	<?=Form::password('password', null, ['id'=> 'inputPassword', 'class' => 'form-control last', 'placeholder' => 'Введите пароль', 'required' => 1]);?>
	<?=Form::submit('signup', 'Войти', ['class'=> 'btn btn-lg btn-primary btn-block']);?>
<?=Form::close();?>
