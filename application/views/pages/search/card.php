<div class="col-sm-4 col-md-3 card" data-id="<?=$card['id']?>">
	<div class="thumbnail">
		<img src="/static/img/cards/<?=$card['img']?>.jpg" alt="<?=$card['name']?>">
		<div class="caption">
			<h3><?=$card['name']?><span class="label label-success pull-right"><?=$card['point']?></span></h3>
			<p><?=$card['description']?></p>
			<a href="#" class="btn btn-primary addHaves" role="button">Есть +1</a>
			<a href="#" class="btn btn-primary addWants" role="button">Хочу +1</a>
		</div>
	</div>
</div>