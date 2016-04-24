<? if ($pager->getCountPage() > 1) {?>
	<div class="pager" data-url="<?=$pager->getUrl()?>" data-onPage="<?=$pager->getOnPage()?>">
		<ul class="">
			<li class="<?= $pager->getCurrentPage() === 1 ? 'disabled' : ''?>">
				<a href="<?= $pager->getCurrentPage() === 1 ? '#' : $pager->getPrevPageUrl();?>"><</a>
			</li>
			<li class="<?= $pager->getCurrentPage() === 1 ? 'active' : ''?>">
				<a href="<?= $pager->getCurrentPage() !== 1 ? $pager->getPageUrl(1) : '#'?>">1</a>
			</li>
			<? if ($pager->getCountPage() > 2) {?>
			<li>
				<input class="current-page" type="text" name="page" value="<?=$pager->getCurrentPage()?>">
			</li>
			<? } ?>
			<li class="<?= $pager->getCurrentPage() === $pager->getCountPage() ? 'active' : ''?>">
				<a href="<?= $pager->getCurrentPage() !== $pager->getCountPage() ? $pager->getPageUrl($pager->getCountPage()) : '#'?>"><?=$pager->getCountPage()?></a>
			</li>
			<li class="<?= $pager->getCurrentPage() === $pager->getCountPage() ? 'disabled' : ''?>">
				<a href="<?= $pager->getCurrentPage() !== $pager->getCountPage() ? $pager->getNextPageUrl() : '#';?>">></a>
			</li>
		</ul>
	</div>
<?}?>