<link href="/static/css/user_collection.css" rel="stylesheet">
<script src="/static/js/collection/Main.js"></script>
<script src="/static/js/cards/QuickAddCard.js"></script>
<ul class="nav nav-pills">
	<li class="form-group navbar-form navbar-left">
		<div class="quick-add">
			<input type="text" class="form-control dropdown-search" placeholder="Быстрое добавление">
			<ul class="dropdown-search-result dropdown-menu">
			</ul>
		</div>
	</li>
	<li class="navbar-form navbar-left">
		<h5>

		</h5>
	</li>
</ul>
<div class="user-collection">
	<div class="content">
		<div class="top-sorts">
			<?= View::factory('pages/collection/sorts')
				->set('expansions', $expansions)
				->set('types', $types)
				->render()
			?>
		</div>
		<div class="left collection-filters">
			<?= View::factory('pages/collection/filters')
				->set('expansions', $expansions)
				->set('rarities', $rarities)
				->set('types', $types)
				->set('colors', $colors)
				->render()?>
		</div>
		<div class="right">
			<div class="row">
				<?= View::factory('pages/collection/card')->render()?>
				<?= View::factory('pages/collection/card')->render()?>
			</div>
		</div>
	</div>
	<div class="bottom">
		<div class="left">
		</div>
	</div>
</div>
<script type="x-template" id="user-card-template" class="hidden">
</script>