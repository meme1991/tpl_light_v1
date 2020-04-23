<?php
/**
 * @version		3.3.0
 * @package		Joomla
 * @subpackage	EShop
 * @author  	Giang Dinh Truong
 * @copyright	Copyright (C) 2012 Ossolution Team
 * @license		GNU/GPL, see LICENSE.php
 */
// no direct access
defined( '_JEXEC' ) or die();
?>
<section class="wrapper container">
	<?php if (isset($this->warning)) : ?>
		<div class="warning"><?php echo $this->warning; ?></div>
	<?php endif; ?>
	<?php if (EshopHelper::getMessageValue('shop_introduction') != '' && EshopHelper::getConfigValue('introduction_display_on', 'front_page') == 'categories_page') : ?>
		<div class="eshop-shop-introduction"><?php echo EshopHelper::getMessageValue('shop_introduction'); ?></div>
	<?php endif; ?>

	<?php if (count($this->items)) : ?>
		<?php if ($this->params->get('show_page_heading')) : ?>
			<h1 class="eshop-categories-heading"><?php echo $this->params->get('page_heading'); ?></h1>
		<?php endif; ?>
		<div class="eshop-categories-list">
			<?php echo EshopHtmlHelper::loadCommonLayout('common/categories.php', array ('categories' => $this->items, 'categoriesPerRow' => $this->categoriesPerRow, 'bootstrapHelper' => $this->bootstrapHelper)); ?>
		</div>
		<?php if ($this->pagination->total > $this->pagination->limit) : ?>
			<div class="pagination">
				<?php echo $this->pagination->getPagesLinks(); ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>
</section>
