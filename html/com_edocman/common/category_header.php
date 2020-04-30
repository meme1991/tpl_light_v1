<div class="sortPagiBar <?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
	<div class="d-flex justify-content-start <?php echo $bootstrapHelper->getClassMapping('span3'); ?>">
		<?php if ($showLayoutswitcher) : ?>
			<strong><?php echo JText::_('EDOCMAN_DISPLAY'); ?></strong>
			<div class="btn-group <?php $bootstrapHelper->getClassMapping('hidden-phone'); ?>">
				<a rel="grid" href="#" class="btn btn-link btn-sm"><i class="fas fa-th-large" title="<?php echo JText::_('EDOCMAN_GRID'); ?>"></i></a>
				<a rel="list" href="#" class="btn btn-link btn-sm"><i class="fas fa-list" title="<?php echo JText::_('EDOCMAN_LIST'); ?>"></i></a>
			</div>
		<?php endif; ?>
	</div>
	<div class="<?php echo $bootstrapHelper->getClassMapping('span9'); ?>">
		<div class="sortPagiBarRight d-flex justify-content-end">
			<div class="edocman-sort-direction">
				<?php echo $lists['filter_order_Dir'] ?>
			</div>
			<div class="edocman-document-sorting">
				<?php echo $lists['filter_order']; ?>
			</div>
		</div>
	</div>
</div>
<div class="clearfix"></div>
