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

if (EshopHelper::getConfigValue('show_sku'))
{
    ?>
    <div class="product-sku">
    	<strong><?php echo JText::_('ESHOP_PRODUCT_CODE'); ?>:</strong>
    	<span><?php echo ($this->option_sku != '' ? $this->option_sku : $this->item->product_sku); ?></span>
    </div>
    <?php
}

if (EshopHelper::getConfigValue('show_availability'))
{
    ?>
    <div class="product-availability">
    	<strong><?php echo JText::_('ESHOP_AVAILABILITY'); ?>:</strong>
    	<span><?php echo ($this->option_quantity != '' ? $this->option_quantity : $this->item->availability); ?></span>
    </div>
    <?php
}

if (EshopHelper::getConfigValue('show_product_weight'))
{
    ?>
    <div class="product-weight">
    	<strong><?php echo JText::_('ESHOP_PRODUCT_WEIGHT'); ?>:</strong>
    	<span><?php echo number_format($this->option_weight != '' ? $this->option_weight : $this->item->product_weight, 2).EshopHelper::getWeightUnit($this->item->product_weight_id, JFactory::getLanguage()->getTag()); ?></span>
    </div>
    <?php   
}       