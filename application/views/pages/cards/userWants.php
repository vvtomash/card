<script src="/static/js/cards/UserWants.js"></script>
<script src="/static/js/cards/QuickAddCard.js"></script>
<ul class="nav nav-pills">
	<div class="form-group navbar-form navbar-left quick-add">
		<input type="text" class="form-control dropdown-search" placeholder="Быстрое добавление">
		<ul class="dropdown-search-result">
		</ul>
	</div>
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