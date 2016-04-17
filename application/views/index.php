<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?=$pageName?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="/static/css/bootstrap.css" rel="stylesheet">
	<link href="/static/css/backbone.notifications.css" rel="stylesheet">
	<link href="/static/css/style.css" rel="stylesheet">
	<link href="/static/css/forms.css" rel="stylesheet">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="/static/js/bootstrap.js"></script>
	<script src="/static/js/underscore.js"></script>
	<script src="/static/js/backbone.js"></script>
	<script src="/static/js/backbone.notification.js"></script>
	<script src="/static/js/main.js"></script>
	<script src="/static/js/ajax.js"></script>
	<script src="/static/js/EventDispatcher.js"></script>
	<script src="/static/js/Pager.js"></script>
</head>
<body>
	<div><?=$header?></div>
	<div><?=$searchBar?></div>
	<div class="main container">
		<?=$content?>
	</div>
	<?=$footer?>
	<?=$profile?>
</body>
</html>