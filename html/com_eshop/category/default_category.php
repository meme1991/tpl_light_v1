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

$bootstrapHelper        = $this->bootstrapHelper;
$rowFluidClass          = $bootstrapHelper->getClassMapping('row-fluid');
$span4Class             = $bootstrapHelper->getClassMapping('span4');
$span6Class             = $bootstrapHelper->getClassMapping('span6');
$span8Class             = $bootstrapHelper->getClassMapping('span8');
$span12Class            = $bootstrapHelper->getClassMapping('span12');
$pullLeftClass          = $bootstrapHelper->getClassMapping('pull-left');
$pullRightClass          = $bootstrapHelper->getClassMapping('pull-right');
$imgPolaroid            = $bootstrapHelper->getClassMapping('img-polaroid');

if (EshopHelper::getConfigValue('show_categories_nav') && (is_object($this->categoriesNavigation[0]) || is_object($this->categoriesNavigation[1]))) : ?>
	<div class="eshop-top-navigation <?php echo $rowFluidClass; ?>">
		<div class="<?php echo $span6Class; ?> eshop-pre-nav">
			<?php if (is_object($this->categoriesNavigation[0])) : ?>
				<a class="btn btn-outline-primary btn-sm <?php echo $pullLeftClass; ?>" href="<?php echo JRoute::_(EshopRoute::getCategoryRoute($this->categoriesNavigation[0]->id)); ?>" title="<?php echo $this->categoriesNavigation[0]->category_page_title != '' ? $this->categoriesNavigation[0]->category_page_title : $this->categoriesNavigation[0]->category_name; ?>">
					<?php echo $this->categoriesNavigation[0]->category_name; ?>
				</a>
			<?php endif; ?>
		</div>
		<div class="<?php echo $span6Class; ?> eshop-next-nav">
			<?php if (is_object($this->categoriesNavigation[1])) : ?>
				<a class="btn btn-outline-primary btn-sm <?php echo $pullRightClass; ?>" href="<?php echo JRoute::_(EshopRoute::getCategoryRoute($this->categoriesNavigation[1]->id)); ?>" title="<?php echo $this->categoriesNavigation[1]->category_page_title != '' ? $this->categoriesNavigation[1]->category_page_title : $this->categoriesNavigation[1]->category_name; ?>">
					<?php echo $this->categoriesNavigation[1]->category_name; ?>
				</a>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>
<?php if (EshopHelper::getConfigValue('show_category_image') || EshopHelper::getConfigValue('show_category_desc')) : ?>
	<div class="row eshop-category-header">
		<?php if (EshopHelper::getConfigValue('show_category_image')) : ?>
			<div class="col-12 d-flex align-items-center">
				<img class="<?php echo $imgPolaroid; ?>" src="<?php echo $this->category->image; ?>" title="<?php echo $this->category->category_page_title != '' ? $this->category->category_page_title : $this->category->category_name; ?>" alt="<?php echo $this->category->category_alt_image != '' ? $this->category->category_alt_image : $this->category->category_name; ?>" />
				<h1 class="eshop-category-main-title">
					<?php echo $this->category->category_page_heading != '' ? $this->category->category_page_heading : $this->category->category_name; ?>
				</h1>
			</div>
		<?php endif; ?>
		<?php if (EshopHelper::getConfigValue('show_category_desc')) : ?>
			<div class="col-12 eshop-category-desc"><?php echo $this->category->category_desc; ?></div>
		<?php endif; ?>
	</div>
	<hr />
<?php endif;
