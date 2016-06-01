<script src="/static/js/cards/UserCards.js"></script>
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
			Всего: <strong><?=$totalInfo['count']?></strong> карт, <strong><?=$totalInfo['points']?></strong> очков
		</h5>
	</li>
	<li class="navbar-right navbar-form">
		<?=$pager?>
	</li>

</ul>

<table class="table table-hover user-cards">
	<thead>
		<tr>
			<th>Set</th>
			<th>Card</th>
			<th>Point</th>
			<th>In Trade</th>
			<th>Foil</th>
			<th>Condition</th>
			<th>Added</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<? foreach ($userCards as $card) {?>
			<tr class="user-card" data-id="<?=$card->id?>"  data-card-id="<?=$card->id?>">
				<td class="set">
					<span  data-toggle="tooltip" title="<?=$card->card_info->set?>"><?= $card->card_info->set_code?></span>
				</td>
				<td class="name">
					<a href="/trades/card/<?=$card->id?>" class="card-data-tooltip-view"><?= substr($card->name, 0, 50);?></a>
				</td>
				<td class="point"><?= $card->getPoint()?></td>
				<td class="status text-center" data-value="<?= $card->status?>" ><span class="glyphicon <? if ($card->status) {?>glyphicon-ok<?} else {?>glyphicon-minus<?}?>"></span></td>
				<td class="foil text-center" data-value="<?= $card->foil?>"><span class="glyphicon glyphicon-minus"></span></td>
				<td class="condition" data-value="<?= $card->condition?>">
					<select class="select-sets selectpicker">
						<? foreach ($config['card']['conditions'] as $key => $condition) { ?>
							<option value="<?=$key?>" <?if($key === $card->condition){?>selected<?}?>><?=$condition['name']?></option>
						<? } ?>
					</select>
				</td>
				<td class="added-timestamp"><?= $card->added_timestamp?></td>
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
			<th>Foil</th>
			<th>Condition</th>
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

<div class="card-data-tooltip popover top">
	<div class="arrow"></div>
	<h3 class="popover-title">Popover top</h3>
	<div class="popover-content">
		<p>
			Sed posuere consectetur est at lobortis.
			Aenean eu leo quam.
			Pellentesque ornare sem lacinia quam venenatis vestibulum.
		</p>
	</div>
</div>

<script type="x-template" id="user-card-template" class="hidden">
	<td class="set">{{= set }}</td>
	<td class="name"><a href="/trades/card/{{= card_id }}">{{= name.substr(0, 50) }}</a></td>
	<td class="point">{{= point }}</td>
	<td class="status text-center" data-value="{{=status}}">
		<span class="glyphicon {{ if(status){ }}glyphicon-ok{{ } else { }}glyphicon-minus{{ } }}"></span>
	</td>
	<td class="foil text-center" data-value="{{=foil}}">
		<span class="glyphicon glyphicon-minus"></span>
	</td>
	<td class="condition" data-value="{{=condition}}">
		<select class="select-sets selectpicker">
			{{ _.each(config.card.conditions, function(condition, key) { }}
				<option value="{{= key }}" {{if (key == 'nm') { }}selected{{ } }}>{{= condition.name }}</option>
			{{ }); }}
		</select>
	</td>
	<td class="added-timestamp">{{= added_timestamp }}</td>
	<td class="remove">
		<a href="#" class="btn btn-danger remove">Remove</a>
	</td>
</script>