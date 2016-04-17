<div class="navbar navbar-default">
	<div class="container">
		<ul class="nav navbar-nav navbar-left">
			<h3><?=$pageName?></h3>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li>
				<form action="/search" method="post" class="navbar-form navbar-right" role="search">
					<div class="input-group">
						<span class="input-group-btn">
							<button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
						</span>
						<input value="<?= empty($searchText)?'':$searchText?>" name="searchText" type="text" class="form-control" placeholder="Поиск карт"  aria-describedby="basic-addon1">
					</div>
				</form>
			</li>
		</ul>
	</div>
</div>