<li class="dropdown <?=$activeMenu['menu'] === 'cards' ? 'active' : '';?>">
	<a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Мои карты<span class="caret"></span></a>
	<ul class="dropdown-menu my-cards">
		<li class="<?=$activeMenu['submenu'] === 'haves' ? 'active' : '';?>"><a href="/cards/haves">В наличии</a></li>
		<li class="<?=$activeMenu['submenu'] === 'wants' ? 'active' : '';?>"><a href="/cards/wants">Хочу</a></li>
		<li class="<?=$activeMenu['submenu'] === 'imports' ? 'active' : '';?>"><a href="/cards/imports">Продаю</a></li>
	</ul>
</li>
