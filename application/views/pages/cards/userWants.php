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
			<th>Set</th>
			<th>Card</th>
			<th>Point</th>
			<th>In Trade</th>
			<th>Added</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<? foreach ($userWants as $want) {?>
		<tr class="user-want" data-id="<?=$want->id?>">
			<td class="set">
				<span  data-toggle="tooltip" title="<?=$want->card_info->set?>"><?= $want->card_info->set_code?></span>
			</td>
			<td class="name"><?= $want->name?></td>
			<td class="point"><?= $want->point?></td>
			<td class="status text-center" data-value="<?= $want->status?>" >
				<span class="glyphicon <? if ($want->status === 'active') {?>glyphicon-ok<?} else {?>glyphicon-minus<?}?>"></span>
			</td>
			<td class="added-timestamp"><?= $want->added_timestamp?></td>
			<td class="remove"><a href="#" class="btn btn-danger remove">Remove</a></td>
		</tr>
		<? } ?>
	</tbody>
	<tfoot>
		<tr>
			<th>Set</th>
			<th>Card</th>
			<th>Point</th>
			<th>In Trade</th>
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

<script type="x-template" id="user-want-template" class="hidden">
	<td class="set">{{= set }}</td>
	<td class="name">{{= name.substr(0, 50) }}</td>
	<td class="point">{{= point }}</td>
	<td class="status text-center" data-value="{{=status}}">
		<span class="glyphicon {{ if(status){ }}glyphicon-ok{{ } else { }}glyphicon-minus{{ } }}"></span>
	</td>
	<td class="added-timestamp">{{= added_timestamp }}</td>
	<td class="remove">
		<a href="#" class="btn btn-danger remove">Remove</a>
	</td>
</script>