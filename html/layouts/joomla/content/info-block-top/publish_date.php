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
<small class="publish-date icon-clock" data-toggle="tooltip" data-placement="top" title="<?php echo JText::_('TPL_LIGHT_PUBLISH_DATE') ?>" itemprop="datePublished" content="<?php echo JHtml::_('date', $displayData['item']->publish_up, JText::_('Y-m-d')) ?>">
	<span class="sr-only"><?php echo JText::_('TPL_LIGHT_PUBLISH_DATE') ?></span>
	<?php echo JHtml::_('date', $displayData['item']->publish_up, JText::_('DATE_FORMAT_LC1')); ?>
</small>
