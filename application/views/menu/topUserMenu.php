<ul class="nav navbar-nav">
	<li class="<?=$activeMenu['menu'] === 'home' ? 'active' : '';?>"><a href="/home">Главная</a></li>
</ul>
<ul class="nav navbar-nav navbar-right">
	<?if (!empty($user)) {?>
		<li role="presentation" class="inbox <?=$activeMenu['menu'] === 'messages' ? 'active' : '';?>">
			<a href="/inbox">Сообщения <span class="badge"><?=$countUnreadMessages?></span></a>
		</li>
		<?=$userCardsMenu?>
		<?=$userTradesMenu?>
		<li class="dropdown">
			<a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?=$user->email?><span class="caret"></span></a>
			<ul class="dropdown-menu">
				<li><a href="/profile">Профиль</a></li>
				<li><a href="/login/logout">Выйти</a></li>
			</ul>
		</li>
	<? } else { ?>
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Вход <span class="caret"></span></a>
			<ul class="dropdown-menu">
				<form action="/login" method="post" class="navbar-form form-signin">
					<input type="email" name="email" class="form-control" placeholder="Введите email">
					<input type="password" name="password"  class="form-control" placeholder="Введите пароль">
					<button type="submit" class="btn btn-success btn-block">Войти</button>
				</form>
			</ul>
		</li>
		<li><span><a class="btn btn-signup" href="/signup">Регистрация</a></span></li>
	<? } ?>
</ul>