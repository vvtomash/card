<div class="navbar navbar-default">
	<div class="container">
		<ul class="nav navbar-nav navbar-left">
			<h3><?=$pageName?></h3>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li>
				<form action="/search" method="post" class="navbar-form navbar-right" role="search">
					<div class="form-group">
						<input value="<?= empty($searchText)?'':$searchText?>" name="searchText" type="text" class="form-control" placeholder="Search">
					</div>
					<button type="submit" class="btn btn-default">Найти</button>
				</form>
			</li>
		</ul>
	</div>
</div>