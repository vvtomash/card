<ul class="nav nav-pills">
	<div class="form-group navbar-form navbar-left quick-add">
		<input type="text" class="form-control dropdown-search" placeholder="Быстрое добавление">
		<ul class="dropdown-search-result">
		</ul>
	</div>
</ul>

<table class="table table-hover user-cards">
	<thead>
		<tr>
			<th>Card</th>
			<th>Point</th>
			<th>Added</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<? foreach ($userCards as $card) {?>
		<tr class="user-card" data-id="<?=$card->id?>">
			<td class="name"><?= $card->name?></td>
			<td class="point"><?= $card->point?></td>
			<td class="added-timestamp"><?= $card->added_timestamp?></td>
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