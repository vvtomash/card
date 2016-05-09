<script src="/static/js/trades/TradeOut.js"></script>
<span id="pageTimer"></span>
<table class="table table-hover sending-cards">
	<thead>
		<tr>
			<th>Card</th>
			<th>Point</th>
			<th>Recepient</th>
			<th>Time start</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<? foreach ($sendingCards as $sendingCard) {?>
			<tr class="sending-card" data-id="<?=$sendingCard->id?>">
				<td class="name"><?= $sendingCard->card->name?></td>
				<td class="point"><?= $sendingCard->card->point?></td>
				<td class="recipient">
					<a href="/profile/user/<?=$sendingCard->recipient->id?>"><?= $sendingCard->recipient->username ?: $sendingCard->recipient->email?></a>
				</td>
				<td class="time-create"><a href="#"><?= $sendingCard->time_create?></a></td>
				<td class="action">
					<? if ($sendingCard->status === 'pending') {?>
						<a href="#" class="btn btn-info send-card confirm-sending">
							Подвердить
							<br><span class="label label-info timer" data-toend="<?= $sendingCard->timeToSend() ?>"></span>
						</a>
					<? } ?>
					<? if ($sendingCard->status === 'debate') {?>
						<span class="label label-danger">Debated</span>
					<? } ?>
				</td>
			</tr>
		<? } ?>
	</tbody>
	<tfoot>
		<tr>
			<th>Card</th>
			<th>Point</th>
			<th>Recepient</th>
			<th>Time start</th>
			<th></th>
		</tr>
	</tfoot>
</table>