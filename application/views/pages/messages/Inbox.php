<script src="/static/js/messenger/Inbox.js"></script>
<script src="/static/js/messenger/PopupMessage.js"></script>
<ul class="nav nav-pills">
	<li class="navbar-form navbar-left">
		<h5>Всего: <?=$counters['read'] + $counters['new']?> сообщений, <?=$counters['new']?> непрочитанных</h5>
	</li>
	<li class="navbar-right navbar-form">
		<?=$pager?>
	</li>
</ul>
<table class="table table-hover inbox">
	<thead>
		<tr>
			<th>From</th>
			<th>Subject</th>
			<th>Body</th>
			<th>Time</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<? foreach ($messages as $message) { ?>
			<tr class="user-message <?= $message->status === 'new' ? 'new-message' : '';?>" data-id="<?=$message->id?>" data-status="<?=$message->status?>">
				<td class="from"><?= $message->author->username?></td>
				<td class="subject"><?= $message->subject?></td>
				<td class="body"><?= substr($message->body, 0, 50)?>...</td>
				<td class="added-timestamp"><?= $message->added_timestamp?></td>
				<td class="remove">
					<a type="button" class="btn btn-default" aria-label="Left Align">
						<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
					</a>
				</td>
			</tr>
		<? } ?>
	</tbody>
	<tfoot>
		<tr>
			<th>From</th>
			<th>Subject</th>
			<th>Body</th>
			<th>Time</th>
			<th></th>
		</tr>
	</tfoot>
</table>
<ul class="nav nav-pills">
	<div class="navbar-right navbar-form">
		<?=$pager?>
	</div>
</ul>

<div class="modal fade" id="popup-message" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Сообщение от <b class="from"></b></h4>
			</div>
			<div class="modal-body">
				<h4><p class="subject"></p></h4>
				<p class="body"></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default close-btn" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>