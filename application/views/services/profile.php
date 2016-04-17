<script>
	$(function() {
		$("a.profiler-switcher").on("click", function() {
			$("div.profiler").toggleClass("hide");
		})
	})
</script>
<a class="profiler-switcher">Profiler</a>
<div class="profiler hide"><?=View::factory('profiler/stats')?></div>