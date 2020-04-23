<?php
/**
 * @version		3.3.0
 * @package		Joomla
 * @subpackage	EShop
 * @author  	Giang Dinh Truong
 * @copyright	Copyright (C) 2012 Ossolution Team
 * @license		GNU/GPL, see LICENSE.php
 */
$span = intval(12 / $subCategoriesPerRow);
$rowFluidClass          = $bootstrapHelper->getClassMapping('row-fluid');
$spanClass              = $bootstrapHelper->getClassMapping('span' . $span);
?>
<div class="<?php echo $rowFluidClass; ?>">
	<?php if (EshopHelper::getConfigValue('sub_categories_layout') == 'list_with_only_link') : ?>
		<h4><?php echo JText::_('ESHOP_REFINE_SEARCH'); ?></h4>
	    <ul>
			<?php foreach ($subCategories as $subCategory) : ?>
				<li>
					<h5>
						<a href="<?php echo JRoute::_(EshopRoute::getCategoryRoute($subCategory->id)); ?>">
							<?php echo $subCategory->category_name; ?>
						</a>
					</h5>
				</li>
			<?php endforeach; ?>
	    </ul>
		<?php else: ?>
		<?php $count = 0; ?>
		<?php foreach ($subCategories as $subCategory) : ?>
			<?php $subCategoryUrl = JRoute::_(EshopRoute::getCategoryRoute($subCategory->id)); ?>
			<div class="eshop-categorys-list-box col-12 col-md-2 <?php //echo $spanClass; ?>">
				<div class="eshop-category-wrap">
        	<div class="image">
						<a href="<?php echo $subCategoryUrl; ?>" title="<?php echo $subCategory->category_page_title != '' ? $subCategory->category_page_title : $subCategory->category_name; ?>">
							<img class="img-fluid" src="<?php echo $subCategory->image; ?>" alt="<?php echo $subCategory->category_alt_image != '' ? $subCategory->category_alt_image : $subCategory->category_name; ?>" />
						</a>
          </div>
					<div class="eshop-info-block">
						<h5>
							<a href="<?php echo $subCategoryUrl; ?>" title="<?php echo $subCategory->category_page_title != '' ? $subCategory->category_page_title : $subCategory->category_name; ?>">
								<?php echo $subCategory->category_name; ?>
							</a>
						</h5>
					</div>
				</div>
			</div>
			<?php $count++; ?>
			<?php if ($count % $subCategoriesPerRow == 0 && $count < count($subCategories)) : ?>
				</div><div class="<?php echo $rowFluidClass; ?>">
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>
</div>
<hr />
