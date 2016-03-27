<script src="/static/js/trades/TradeIn.js"></script>
<table class="table table-hover receiving-cards">
	<thead>
		<tr>
			<th>Card</th>
			<th>Point</th>
			<th>Sender</th>
			<th>Time start</th>
			<th colspan="2"></th>
		</tr>
	</thead>
	<tbody>
		<? foreach ($receivingCards as $receivingCard) {?>
		<tr class="receiving-card" data-id="<?=$receivingCard->id?>">
			<td class="name"><?= $receivingCard->card->name?></td>
			<td class="point"><?= $receivingCard->card->point?></td>
			<td class="sender"><a href="#"><?= $receivingCard->recipient->email?></a></td>
			<td class="time-create"><a href="#"><?= $receivingCard->time_create?></a></td>
			<td class="open-debate">
				<? if ($receivingCard->status !== 'debate') {?>
					<a href="#" class="btn btn-danger send-card">Open debate</a>
				<?}?>
			</td>
			<td class="complete-trade"><a href="#" class="btn btn-success send-card">Complete</a></td>
		</tr>
		<? } ?>
	</tbody>
	<tfoot>
		<tr>
			<th>Card</th>
			<th>Point</th>
			<th>Sender</th>
			<th>Time start</th>
			<th colspan="2"></th>
		</tr>
	</tfoot>
</table>