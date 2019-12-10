<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

$item   = $displayData['item'];
$link   = JRoute::_(ContentHelperRoute::getCategoryRoute($item->id, $item->language));
?>
<div class="">
  <a href="<?php echo $link ?>" class="btn btn-outline-primary btn-block" title="<?php echo $this->escape($item->title) ?>">
    <?php echo JText::_('TPL_LIGHT_ACCESS') ?>
  </a>
</div>
