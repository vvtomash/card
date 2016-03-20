<script src="/static/js/search/SearchMain.js"></script>
<script>
	var searchResult = <?=json_encode($cards);?>;
</script>
<div class="row search-result">
	<? foreach ($cards as $card) { ?>
		<?= View::factory('pages/search/card')->set('card', $card)->render(); ?>
	<? } ?>
</div>