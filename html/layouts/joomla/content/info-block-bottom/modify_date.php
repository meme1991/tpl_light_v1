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
<small class="modified-date font-italic" data-toggle="tooltip" data-placement="top" title="<?php echo JText::_('TPL_LIGHT_MODIFIED_DATE') ?>" itemprop="dateModified" content="<?php echo JHtml::_('date', $displayData['item']->modified, JText::_('Y-m-d')) ?>">
  <i class="fal fa-pencil-alt"></i>
  <span class="sr-only"><?php echo JText::_('TPL_LIGHT_MODIFIED_DATE') ?></span>
  <?php echo JHtml::_('date', $displayData['item']->modified, JText::_('DATE_FORMAT_LC1')) ?>
</small>
