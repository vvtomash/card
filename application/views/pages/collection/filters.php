<script src="/static/js/collection/Filters.js"></script>
<form action="collection">
	<div>
		<div class="input-group">
			<input name="searchText" type="text" class="form-control" placeholder="Поиск карт">
		</div>
	</div>
	<div>
		<select name="set" class="select-expansion selectpicker" multiple>
			<? foreach($expansions as $expansion) {?>
				<option value="<?=$expansion['id']?>" class="text-right" data-content="<span><img class='option-icon pull-left' src='/static/img/expansions/small/<?=strtolower($expansion['short_name'])?>.png'/><?=$expansion['short_name']?></span>"></option>
			<? } ?>
		</select>
	</div>
	<div>
		<select name="type" class="select-type selectpicker" multiple>
			<? foreach($types as $type) {?>
				<option value="<?=$type['id']?>"><?=$type['type']?></option>
			<? } ?>
		</select>
	</div>
	<div>
		<select name="color" class="select-color selectpicker" multiple>
			<? foreach($colors as $color) {?>
				<option value="<?=$color['id']?>" class="text-right" data-content="<span><img class='option-icon pull-left' src='/static/img/colors/<?=$color['color']?>.png'/><?=$color['color']?></span>"></option>
			<? } ?>
		</select>
	</div>
	<div>
		<select name="cmc" class="select-cmc selectpicker" multiple>
			<option>0</option>
			<option>1</option>
			<option>2</option>
			<option>3</option>
			<option>4</option>
			<option>5</option>
		</select>
	</div>
	<div>
		<select name="rarity" class="select-rarity selectpicker" multiple>
			<? foreach($rarities as $rarity) {?>
				<option value="<?=$rarity['id']?>"><?=ucfirst($rarity['name'])?></option>
			<? } ?>
		</select>
	</div>
	<div>
		<button type="submit" class="apply-filters btn btn-primary">
			 Искать!
		</button>
	</div>
</form>
