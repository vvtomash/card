<script src="/static/js/trades/SendCard.js"></script>

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
			<td class="user"><a href="#"><?= $card->user->email?></a></td>
			<td class="send"><a href="#" class="btn btn-info send-card">Send Card</a></td>
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