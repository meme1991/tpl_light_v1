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
$rowFluidClass          = $bootstrapHelper->getClassMapping('row-fluid');
$span3Class             = $bootstrapHelper->getClassMapping('span3');
$imgPolaroid            = $bootstrapHelper->getClassMapping('img-polaroid');
?>
<div class="plugin_products <?php echo $rowFluidClass; ?>">
    <?php
    for ($i = 0; $n = count($products), $i < $n; $i++)
    {
    	$product = $products[$i];
    	?>
    	<div class="<?php echo $span3Class; ?>">
    		<div class="image <?php echo $imgPolaroid; ?>">
    			<a href="<?php echo JRoute::_(EshopRoute::getProductRoute($product->id, EshopHelper::getProductCategory($product->id))); ?>">
    				<img src="<?php echo $product->thumb_image; ?>" title="<?php echo $product->product_page_title != '' ? $product->product_page_title : $product->product_name; ?>" alt="<?php echo $product->product_alt_image != '' ? $product->product_alt_image : $product->product_name; ?>" />
        			</a>
              	</div>
                <div class="name">
                    <a href="<?php echo JRoute::_(EshopRoute::getProductRoute($product->id, EshopHelper::getProductCategory($product->id))); ?>">
                        <h5><?php echo $product->product_name; ?></h5>
                    </a>
                    <?php
                    if (EshopHelper::showPrice() && !$product->product_call_for_price)
                    {
                        echo JText::_('ESHOP_PRICE'); ?>:
                        <?php
                        $productPriceArray = EshopHelper::getProductPriceArray($product->id, $product->product_price);
                        if ($productPriceArray['salePrice'] >= 0)
                        {
                            ?>
                            <span class="eshop-base-price"><?php echo $currency->format($tax->calculate($productPriceArray['basePrice'], $product->product_taxclass_id, EshopHelper::getConfigValue('tax'))); ?></span>&nbsp;
                            <span class="eshop-sale-price"><?php echo $currency->format($tax->calculate($productPriceArray['salePrice'], $product->product_taxclass_id, EshopHelper::getConfigValue('tax'))); ?></span>
                            <?php
                        }
                        else
                        {
                            ?>
                            <span class="price"><?php echo $currency->format($tax->calculate($productPriceArray['basePrice'], $product->product_taxclass_id, EshopHelper::getConfigValue('tax'))); ?></span>
                            <?php
                        }
                    }
                    if ($product->product_call_for_price)
                    {
                    	?>
    					<span class="call-for-price">
    						<?php echo JText::_('ESHOP_CALL_FOR_PRICE'); ?>: <?php echo EshopHelper::getConfigValue('telephone'); ?>
    					</span>
    					<?php
                    }
                    ?>
                </div>
    		</div>
    		<?php
    	if ($i > 0 && ($i + 1) % 4 == 0)
    	{
    		?>
    		</div><div class="plugin_products <?php echo $rowFluidClass; ?>">
    		<?php
    	}
    }
    ?>
</div>