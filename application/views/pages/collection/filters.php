<script src="/static/js/collection/Filters.js"></script>
<form action="/search-collection" method="get" role="search">
	<div>
		<div class="input-group">
			<input name="searchText" type="text" class="form-control" placeholder="Поиск карт">
		</div>
	</div>
	<div>
		<select class="select-sets selectpicker" multiple >
			<option data-content="<img class='option-icon' src='/static/img/sets/small/bfz.png'/>"></option>
			<option data-content="<img class='option-icon' src='/static/img/sets/small/dtk.png'/>"></option>
			<option data-content="<img class='option-icon' src='/static/img/sets/small/ogw.png'/>"></option>
			<option data-content="<img class='option-icon' src='/static/img/sets/small/pd3.png'/>"></option>
			<option data-content="<img class='option-icon' src='/static/img/sets/small/ori.png'/>"></option>
			<option data-content="<img class='option-icon' src='/static/img/sets/small/soi.png'/>"></option>
			<option data-content="<img class='option-icon' src='/static/img/sets/small/v10.png'/>"></option>
		</select>
	</div>
	<div>
		<select class="select-types selectpicker" multiple>
			<? foreach($types as $type) {?>
				<option value="<?=$type['id']?>"><?=$type['type']?></option>
			<? } ?>
		</select>
	</div>
	<div>
		<select class="select-colors selectpicker" multiple>
			<option data-content="<img class='option-icon' src='/static/img/colors/white.png'/>"></option>
			<option data-content="<img class='option-icon' src='/static/img/colors/blue.png'/>"></option>
			<option data-content="<img class='option-icon' src='/static/img/colors/black.png'/>"></option>
			<option data-content="<img class='option-icon' src='/static/img/colors/red.png'/>"></option>
			<option data-content="<img class='option-icon' src='/static/img/colors/green.png'/>"></option>
		</select>
	</div>
	<div>
		<select class="select-cmc selectpicker" multiple>
			<option>0</option>
			<option>1</option>
			<option>2</option>
			<option>3</option>
			<option>4</option>
			<option>5</option>
		</select>
	</div>
	<div>
		<select class="select-rarity selectpicker" multiple>
			<option>Common</option>
			<option>Uncommon</option>
			<option>Rare</option>
			<option>Mythic</option>
		</select>
	</div>
	<div>
		<button type="submit" class="btn btn-primary">
			 Искать!
		</button>
	</div>
</form>
