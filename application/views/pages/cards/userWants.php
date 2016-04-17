<script src="/static/js/cards/UserWants.js"></script>
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
		<h5>Всего: <?=$totalInfo['count']?> карт, <?=$totalInfo['points']?> очков</h5>
	</li>
	<li class="navbar-right navbar-form">
		<?=$pager?>
	</li>
</ul>

<table class="table table-hover user-wants">
	<thead>
		<tr>
			<th>Card</th>
			<th>Point</th>
			<th>Added</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<? foreach ($userWants as $want) {?>
		<tr class="user-want" data-id="<?=$want->id?>">
			<td class="name"><?= $want->name?></td>
			<td class="point"><?= $want->point?></td>
			<td class="added-timestamp"><?= $want->added_timestamp?></td>
			<td class="remove"><a href="#" class="btn btn-danger remove">Remove</a></td>
		</tr>
		<? } ?>
	</tbody>
	<tfoot>
		<tr>
			<th>Card</th>
			<th>Point</th>
			<th>Added</th>
			<th></th>
		</tr>
	</tfoot>
</table>
<ul class="nav nav-pills">
	<div class="navbar-right navbar-form">
		<?=$pager?>
	</div>
</ul>