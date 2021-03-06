<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

?>
<?php if ($displayData->params->get('show_page_heading')) : ?>
	<div class="row">
		<div class="col-12">
			<?php echo JLayoutHelper::render('joomla.content.title.title_page', $displayData->escape($displayData->params->get('page_heading'))); ?>
		</div>
	</div>
<?php endif; ?>

<?php if ($displayData->params->get('show_base_description')) : ?>
<div class="row">
	<?php // If there is a description in the menu parameters use that; ?>
	<?php if ($displayData->params->get('categories_description')) : ?>
		<div class="col-12 category-desc mt-3">
			<?php echo JHtml::_('content.prepare', $displayData->params->get('categories_description'), '',  $displayData->get('extension') . '.categories'); ?>
		</div>
	<?php else : ?>
		<?php // Otherwise get one from the database if it exists. ?>
		<?php if ($displayData->parent->description) : ?>
			<div class="col-12 category-desc mt-3">
				<?php echo JHtml::_('content.prepare', $displayData->parent->description, '', $displayData->parent->extension . '.categories'); ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>
</div>
<?php endif; ?>
