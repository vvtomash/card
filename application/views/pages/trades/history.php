<table class="table table-hover history-trades">
	<thead>
		<tr>
			<th>Card</th>
			<th>Point</th>
			<th>Type Trade</th>
			<th>Trader</th>
			<th>Status</th>
			<th>Start Time</th>
			<th>Close Time</th>
		</tr>
	</thead>
	<tbody>
		<? foreach ($historyTrades as $trade) { ?>
		<tr class="history-trade" data-id="<?=$trade->id?>">
			<td class="name"><?= $trade->card->name?></td>
			<td class="point"><?= $trade->card->point?></td>
			<td class="trade"><?= $trade->recipient_id === $user->id ? 'Incoming' : 'Outcoming';?></td>
			<td class="trader"><?= $trade->recipient_id === $user->id ? $trade->sender->email : $trade->recipient->email;?></td>
			<td class="status"><?= $trade->status?></td>
			<td class="time-create"><a href="#"><?= $trade->time_create?></a></td>
			<td class="time-close"><a href="#"><?= $trade->time_closed?></a></td>
		</tr>
		<? } ?>
	</tbody>
	<tfoot>
		<tr>
			<th>Card</th>
			<th>Point</th>
			<th>Type Trade</th>
			<th>Trader</th>
			<th>Status</th>
			<th>Start Time</th>
			<th>Close Time</th>
		</tr>
	</tfoot>
</table>