<? if (isset($userCard) && empty($userCard->id)) { ?>
<div class="alert alert-danger" role="alert">
	У вас нет такой карты в наличии.
	<a href="/cards/haves" class="alert-link">К своим картам</a>
</div>
<? } else { ?>
<script src="/static/js/trades/SendCard.js"></script>
<script src="/static/js/trades/ConfirmSendingPopup.js"></script>
<ul class="nav nav-pills">
	<li class="navbar-form navbar-left">
		<h5>
			Всего завершено: <strong><?=$counters['complete']?></strong> сделок,
			в процессе <strong><?=$counters['sending']+$counters['pending']?></strong>
		</h5>
	</li>
</ul>
<table class="table table-hover want-cards">
	<thead>
		<tr>
			<th>Card</th>
			<th>Point</th>
			<th>User</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<? foreach ($wants as $card) {?>
		<tr class="want-card" data-id="<?=$card->id?>">
			<td class="name"><?= $card->card->name?></td>
			<td class="point"><?= $card->card->point?></td>
			<td class="user">
				<a href="/profile/user/<?=$card->user->id?>"><?= $card->user->username ?></a>
			</td>
			<td class="send">
				<? if ($card->canSend) {?>
					<a href="#" class="btn btn-info send-card" data-recipient-id="<?=$card->user->id?>">Send Card</a>
				<? } ?>
			</td>
		</tr>
		<? } ?>
	</tbody>
	<tfoot>
		<tr>
			<th>Card</th>
			<th>Point</th>
			<th>User</th>
			<th></th>
		</tr>
	</tfoot>
</table>
<ul class="nav nav-pills">
</ul>
<div class="modal fade" id="popup-confirm-sending" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Подтверждение сделки <strong class="recipient username"></strong></h4>
			</div>
			<div class="modal-body">
				<p>
					Вы подверждаете отправление карты. В течение 48 часов вы должны отправить карту получателю и подвердить отправку на сайте.
				</p>
				<p>
					В случае подверждения сделки, вы должны в течение 48 часов отправить карту по адресу:
					<strong class="postal">
						<p>
							<span class="address"></span>,
							<span class="city"></span>,
							<span class="country"></span>
						</p>
						<p>
							<span class="first_name"></span>&nbsp;
							<span class="last_name"></span>
						</p>
					</strong>
				</p>
				<p>
					Если отправка не будет подверждена, сделка автоматически аннулируется.
					Будьте внимательны, в случае автоматической отмены сделки, это может негативно повляить на ваш рейтинг продавца.
				</p>
			</div>
			<div class="modal-footer">
				<!--<div class="progress">
					<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
						<span class="sr-only">40% Complete (success)</span>
					</div>
				</div>-->
				<button type="button" class="btn btn-default close-btn" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-success send" data-dismiss="modal">Send</button>
			</div>
		</div>
	</div>
</div>
<? } ?>