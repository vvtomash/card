<script src="/static/js/search/SearchMain.js"></script>
<script src="/static/js/search/Filters.js"></script>
<script>
	var searchResult = <?=json_encode($cards);?>;
</script>
<ul class="nav nav-pills">
	<li class="navbar-form navbar-left">
		<h5>Всего найдено: <?=$searchCount;?></h5>
	</li>
	<li class="navbar-left navbar-form">
		<button type="button" class="search-filters-btn btn btn-default btn-md"><span class="glyphicon glyphicon-cog"></span> Расширенный поиск</button>
	</li>
	<li class="navbar-right navbar-form">
		<?=$pager?>
	</li>
</ul>
<ul class="nav nav-pills hidden search-filters">
	<li class="navbar-form navbar-left">
		<span>Сет: </span>
		<select class="select-sets selectpicker" multiple>
			<option>Mustard</option>
			<option>Ketchup</option>
			<option>Relish</option>
		</select>
	</li>
	<li class="navbar-form navbar-left">
		<span>Цвета: </span>
		<select class="select-colors selectpicker" multiple>
			<option>Mustard</option>
			<option>Ketchup</option>
			<option>Relish</option>
		</select>
	</li>
</ul>
<div class="row search-result">
	<? foreach ($cards as $card) { ?>
		<?= View::factory('pages/search/card')->set('card', $card)->render(); ?>
	<? } ?>
</div>
<ul class="nav nav-pills">
	<li class="navbar-form navbar-left">
		<h5>Всего найдено: <?=$searchCount;?></h5>
	</li>
	<li class="navbar-right navbar-form">
		<?=$pager?>
	</li>
</ul>