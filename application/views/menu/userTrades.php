<li class="dropdown <?=$activeMenu['menu'] === 'trades' ? 'active' : '';?>">
	<a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Сделки<span class="caret"></span></a>
	<ul class="dropdown-menu my-cards">
		<li class="<?=$activeMenu['submenu'] === 'send' ? 'active' : '';?>"><a href="/trades/send">Послать</a></li>
		<li class="<?=$activeMenu['submenu'] === 'sending' ? 'active' : '';?>"><a href="/trades/sending">Отсылаются</a></li>
		<li class="<?=$activeMenu['submenu'] === 'receiving' ? 'active' : '';?>"><a href="/trades/receiving">Доставляются</a></li>
		<li class="<?=$activeMenu['submenu'] === 'history' ? 'active' : '';?>"><a href="/trades/history">История</a></li>
		<li class="<?=$activeMenu['submenu'] === 'partners' ? 'active' : '';?>"><a href="/trades/partners">Партнеры</a></li>
	</ul>
</li>