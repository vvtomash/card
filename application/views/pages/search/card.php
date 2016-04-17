<div class="col-sm-4 col-md-3 card" data-id="<?=$card['id']?>">
	<div class="thumbnail">
		<img src="<?=$card['img']?>" alt="<?=$card['name']?>">
		<div class="caption">
			<h5 class="text-nowrap"><?=$card['name']?><span class="label label-success pull-right"><?=$card['point']?></span></h5>
<!--			<p>--><?//=$card['description']?><!--</p>-->
			<div class="actions">
				<a href="#" class="btn btn-primary addHaves" role="button">Есть +1</a>
				<a href="#" class="btn btn-primary addWants" role="button">Хочу +1</a>
			</div>
		</div>
	</div>
</div>