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
$tmpl = JFactory::getApplication()->getTemplate();
require_once JPATH_ROOT . '/templates/'.$tmpl.'/libreries/MyEshopHelper.inc.php';
?>
<section class="wrapper container">
<?php
$uri = JUri::getInstance();
$bootstrapHelper        = $this->bootstrapHelper;
$rowFluidClass          = $bootstrapHelper->getClassMapping('row-fluid');
$span3Class             = $bootstrapHelper->getClassMapping('span3');
$span4Class             = $bootstrapHelper->getClassMapping('span4');
$span6Class             = $bootstrapHelper->getClassMapping('span6');
$span8Class             = $bootstrapHelper->getClassMapping('span8');
$span12Class            = $bootstrapHelper->getClassMapping('span12');
$pullLeftClass          = $bootstrapHelper->getClassMapping('pull-left');
$pullRightClass         = $bootstrapHelper->getClassMapping('pull-right');
$controlGroupClass      = $bootstrapHelper->getClassMapping('control-group');
$controlLabelClass      = $bootstrapHelper->getClassMapping('control-label');
$controlsClass          = $bootstrapHelper->getClassMapping('controls');
$inputAppendClass       = $bootstrapHelper->getClassMapping('input-append');
$inputPrependClass      = $bootstrapHelper->getClassMapping('input-prepend');
$imgPolaroid            = $bootstrapHelper->getClassMapping('img-polaroid');
$btnClass				= $bootstrapHelper->getClassMapping('btn');

$gridRatioImageInfo     = EshopHelper::getConfigValue('grid_ratio_image_info');

switch ($gridRatioImageInfo)
{
    case '2:10':
        $imageSpanClass = $bootstrapHelper->getClassMapping('span2');
        $infoSpanClass  = $bootstrapHelper->getClassMapping('span10');
        break;
    case '3:9':
        $imageSpanClass = $bootstrapHelper->getClassMapping('span3');
        $infoSpanClass  = $bootstrapHelper->getClassMapping('span9');
        break;
    case '5:7':
        $imageSpanClass = $bootstrapHelper->getClassMapping('span5');
        $infoSpanClass  = $bootstrapHelper->getClassMapping('span7');
        break;
    case '6:6':
        $imageSpanClass = $bootstrapHelper->getClassMapping('span6');
        $infoSpanClass  = $bootstrapHelper->getClassMapping('span6');
        break;
    case '7:5':
        $imageSpanClass = $bootstrapHelper->getClassMapping('span7');
        $infoSpanClass  = $bootstrapHelper->getClassMapping('span5');
        break;
    case '8:4':
        $imageSpanClass = $bootstrapHelper->getClassMapping('span8');
        $infoSpanClass  = $bootstrapHelper->getClassMapping('span4');
        break;
    case '9:3':
        $imageSpanClass = $bootstrapHelper->getClassMapping('span9');
        $infoSpanClass  = $bootstrapHelper->getClassMapping('span3');
        break;
    case '10:2':
        $imageSpanClass = $bootstrapHelper->getClassMapping('span10');
        $infoSpanClass  = $bootstrapHelper->getClassMapping('span2');
        break;
    case '4:8':
    default:
        $imageSpanClass = $bootstrapHelper->getClassMapping('span4');
        $infoSpanClass  = $bootstrapHelper->getClassMapping('span8');
        break;
}
?>
<script src="<?php echo JUri::base(true); ?>/components/com_eshop/assets/colorbox/jquery.colorbox.js" type="text/javascript"></script>
<script src="<?php echo JUri::base(true); ?>/components/com_eshop/assets/js/slick.js" type="text/javascript"></script>
<script src="<?php echo JUri::base(true); ?>/components/com_eshop/assets/js/eshop-pagination.js" type="text/javascript"></script>
<?php
if (EshopHelper::getConfigValue('view_image') == 'zoom')
{
	?>
	<script src="<?php echo JUri::base(true); ?>/components/com_eshop/assets/js/jquery.jqzoom-core.js" type="text/javascript"></script>
	<script type="text/javascript">
		Eshop.jQuery(document).ready(function($) {
			$('.product-image-zoom').jqzoom();
			$('.product-options select, .product-options input[type="radio"], .product-options input[type="checkbox"]').change(function(e) {
				if ((this.length || this.checked) && $('#option-image-' + $(this).val()).length) {
					$('#option-image-' + $(this).val()).click();
				}
				else {
					$('.image-additional .slick-slide:first-child').children().click();
				}
        	});
    	});
	</script>
	<?php
}
else
{
	?>
	<script type="text/javascript">
		Eshop.jQuery(document).ready(function($) {
		    $(".product-image").colorbox({
		        rel: 'colorbox'
		    });
		    var mainimage = $('#main-image-area');
		    $('.option-image').each(function() {
		        $(this).children().each(function() {
		            mainimage.append($(this).clone().removeAttr('class').removeAttr('id').removeAttr('href').addClass($(this).attr('id')).hide().click(function() {
		                $('#' + $(this).attr('class')).click();
		            }));
		        });
		    });
		    $('.product-options select, .product-options input[type="radio"], .product-options input[type="checkbox"]').change(function(e) {
		        if ((this.length || this.checked) && $('.option-image-' + $(this).val()).length)
	    	    {
		        	mainimage.children().hide();
	        	    $('.option-image-' + $(this).val()).show();
	    	    }
		    });
		});
	</script>
	<?php
}
if (EshopHelper::getConfigValue('show_products_nav') && (is_object($this->productsNavigation[0]) || is_object($this->productsNavigation[1])))
{
	?>
	<div class="eshop-top-navigation <?php echo $rowFluidClass; ?>">
		<div class="<?php echo $span6Class; ?> eshop-pre-nav">
			<?php
			if (is_object($this->productsNavigation[0]))
			{
				?>
				<a class="btn btn-outline-primary btn-sm <?php echo $pullLeftClass; ?>" href="<?php echo JRoute::_(EshopRoute::getProductRoute($this->productsNavigation[0]->id, isset($this->productsNavigation[0]->category_id) ? $this->productsNavigation[0]->category_id : EshopHelper::getProductCategory($this->productsNavigation[0]->id))); ?>" title="<?php echo $this->productsNavigation[0]->product_page_title != '' ? $this->productsNavigation[0]->product_page_title : $this->productsNavigation[0]->product_name; ?>">
					<?php echo $this->productsNavigation[0]->product_name; ?>
				</a>
				<?php
			}
			?>
		</div>
		<div class="<?php echo $span6Class; ?> eshop-next-nav">
			<?php
			if (is_object($this->productsNavigation[1]))
			{
				?>
				<a class="btn btn-outline-primary btn-sm <?php echo $pullRightClass; ?>" href="<?php echo JRoute::_(EshopRoute::getProductRoute($this->productsNavigation[1]->id, isset($this->productsNavigation[1]->category_id) ? $this->productsNavigation[1]->category_id : EshopHelper::getProductCategory($this->productsNavigation[1]->id))); ?>" title="<?php echo $this->productsNavigation[1]->product_page_title != '' ? $this->productsNavigation[1]->product_page_title : $this->productsNavigation[1]->product_name; ?>">
					<?php echo $this->productsNavigation[1]->product_name; ?>
				</a>
				<?php
			}
			?>
		</div>
	</div>
  <?php
}
?>
<!-- Microdata for Rich Snippets - See details at https://developers.google.com/search/docs/data-types/product -->
<?php
if (EshopHelper::getConfigValue('rich_snippets') == '1')
{
	?>
	<div  itemscope itemtype="http://schema.org/Product" style="display: none;">
		<meta itemprop="mpn" content="<?php echo $this->item->product_sku; ?>" />
		<meta itemprop="sku" content="<?php echo $this->item->product_sku; ?>" />
		<meta itemprop="name" content="<?php echo $this->item->product_name; ?>" />
		<?php
		if ($this->item->thumb_image)
		{
			?>
			<link itemprop="image" href="<?php echo EshopHelper::getSiteUrl() . $this->item->thumb_image; ?>" />
			<?php
		}

		if ($this->item->product_short_desc)
		{
			$description = $this->item->product_short_desc;
		}
		else
		{
			$description = $this->item->product_desc;
		}

		$description = utf8_substr(strip_tags(html_entity_decode($description, ENT_QUOTES, 'UTF-8')), 0, 100) . '..';
		?>
		<meta itemprop="description" content="<?php echo $description; ?>" />

		<?php
		if (is_object($this->manufacturer) && $this->manufacturer->manufacturer_name != '')
		{
			?>
			<meta itemprop="brand" content="<?php echo $this->manufacturer->manufacturer_name; ?>" />
			<?php
		}

		if (EshopHelper::getConfigValue('allow_reviews') && count($this->productReviews))
		{
			?>
			<div itemprop="aggregateRating" itemtype="http://schema.org/AggregateRating" itemscope>
				<meta itemprop="reviewCount" content="<?php echo count($this->productReviews); ?>" />
				<meta itemprop="ratingValue" content="<?php echo EshopHelper::getProductRating($this->item->id); ?>" />
			</div>
			<?php
			foreach ($this->productReviews as $review)
			{
			    ?>
				<div itemprop="review" itemtype="http://schema.org/Review" itemscope>
					<div itemprop="author" itemtype="http://schema.org/Person" itemscope>
						<meta itemprop="name" content="<?php echo $review->author; ?>" />
					</div>
					<div itemprop="reviewRating" itemtype="http://schema.org/Rating" itemscope>
						<meta itemprop="ratingValue" content="<?php echo $review->rating; ?>" />
						<meta itemprop="bestRating" content="5" />
					</div>
				</div>
			    <?php
			}
		}
		?>
		<div itemprop="offers" itemtype="http://schema.org/Offer" itemscope>
			<link itemprop="url" href="<?php echo JUri::getInstance()->toString(); ?>" />
			<?php
			if (EshopHelper::getConfigValue('show_availability'))
			{
			    if ($this->item->product_quantity > 0)
			    {
			        $availability = "http://schema.org/InStock";
			    }
			    else
			    {
			        $availability = "http://schema.org/OutOfStock";
			    }
                ?>
				<meta itemprop="availability" content="<?php echo $availability; ?>" />
				<?php
            }

			if (EshopHelper::showPrice() && !$this->item->product_call_for_price)
			{
				?>
				<meta itemprop="price" content="<?php echo $this->currency->format($this->item->product_price, '', '', false); ?>" />
				<meta itemprop="priceCurrency" content="<?php echo $this->currency->getCurrencyCode(); ?>" />
				<?php
			}
			?>
		</div>
    </div>
    <?php
}
?>
<div class="product-info">
  <!-- <div class="category_name"> -->
    <?php $category_details = getCategoryName($this->item->id); ?>
    <?php $categoryUrl = JRoute::_(EshopRoute::getCategoryRoute($category_details->category_id));	?>
    <!-- <p><a href="<?= $categoryUrl ?>"><?= $category_details->category_name ?></a></p> -->
  <!-- </div> -->

  <h4 class="eshop-category_name">
    <a href="<?= $categoryUrl ?>"><?= $category_details->category_name ?></a>
  </h4>
	<h1 class="eshop-product-title">
    <?php echo $this->item->product_page_heading != '' ? $this->item->product_page_heading : $this->item->product_name; ?>
  </h1>
	<div class="<?php echo $rowFluidClass; ?>">
		<div class="<?php echo $imageSpanClass; ?>">
			<?php
			if (EshopHelper::getConfigValue('view_image') == 'zoom')
			{
				?>
				<div class="image <?php echo $imgPolaroid; ?>" id="main-image-area">
					<a href="<?php echo $this->item->popup_image; ?>" class="product-image-zoom" rel="product-thumbnails" title="<?php echo $this->item->product_name; ?>">
						<?php
						if (count($this->labels))
						{
							for ($i = 0; $n = count($this->labels), $i < $n; $i++)
							{
								$label = $this->labels[$i];
								if ($label->label_style == 'rotated' && !($label->enable_image && $label->label_image))
								{
									?>
									<div class="cut-rotated">
									<?php
								}
								if ($label->enable_image && $label->label_image)
								{
									$imageWidth = $label->label_image_width > 0 ? $label->label_image_width : EshopHelper::getConfigValue('label_image_width');
									if (!$imageWidth)
										$imageWidth = 50;
									$imageHeight = $label->label_image_height > 0 ? $label->label_image_height : EshopHelper::getConfigValue('label_image_height');
									if (!$imageHeight)
										$imageHeight = 50;
									?>
									<span class="horizontal <?php echo $label->label_position; ?> small-db" style="opacity: <?php echo $label->label_opacity; ?>;<?php echo 'background-image: url(' . $label->label_image . ')'; ?>; background-repeat: no-repeat; width: <?php echo $imageWidth; ?>px; height: <?php echo $imageHeight; ?>px; box-shadow: none;"></span>
									<?php
								}
								else
								{
									?>
									<span class="<?php echo $label->label_style; ?> <?php echo $label->label_position; ?> small-db" style="background-color: <?php echo '#'.$label->label_background_color; ?>; color: <?php echo '#'.$label->label_foreground_color; ?>; opacity: <?php echo $label->label_opacity; ?>;<?php if ($label->label_bold) echo 'font-weight: bold;'; ?>">
										<?php echo $label->label_name; ?>
									</span>
									<?php
								}
								if ($label->label_style == 'rotated' && !($label->enable_image && $label->label_image))
								{
									?>
									</div>
									<?php
								}
							}
						}
						?>
						<img src="<?php echo $this->item->thumb_image; ?>" title="<?php echo $this->item->product_page_title != '' ? $this->item->product_page_title : $this->item->product_name; ?>" alt="<?php echo $this->item->product_alt_image != '' ? $this->item->product_alt_image : $this->item->product_name; ?>" />
					</a>
				</div>
				<?php
				if (count($this->productImages))
				{
					?>
					<div class="image-additional">
						<div>
							<a class="zoomThumbActive" href="javascript:void(0);" rel="{gallery: 'product-thumbnails', smallimage: '<?php echo $this->item->thumb_image; ?>',largeimage: '<?php echo $this->item->popup_image; ?>'}">
								<img src="<?php echo $this->item->small_thumb_image; ?>" title="<?php echo $this->item->product_page_title != '' ? $this->item->product_page_title : $this->item->product_name; ?>" alt="<?php echo $this->item->product_alt_image != '' ? $this->item->product_alt_image : $this->item->product_name; ?>" />
							</a>
						</div>
						<?php
						for ($i = 0; $n = count($this->productImages), $i < $n; $i++)
						{
							?>
							<div>
								<a href="javascript:void(0);" rel="{gallery: 'product-thumbnails', smallimage: '<?php echo $this->productImages[$i]->thumb_image; ?>',largeimage: '<?php echo $this->productImages[$i]->popup_image; ?>'}">
									<img src="<?php echo $this->productImages[$i]->small_thumb_image; ?>" title="<?php echo $this->item->product_page_title != '' ? $this->item->product_page_title : $this->item->product_name; ?>" alt="<?php echo $this->item->product_alt_image != '' ? $this->item->product_alt_image : $this->item->product_name; ?>" />
								</a>
							</div>
							<?php
						}
						?>
					</div>
					<?php
				}
			}
			else
			{
				?>
				<div class="image <?php echo $imgPolaroid; ?>" id="main-image-area">
					<a class="product-image" href="<?php echo $this->item->popup_image; ?>">
						<?php
						if (count($this->labels))
						{
							for ($i = 0; $n = count($this->labels), $i < $n; $i++)
							{
								$label = $this->labels[$i];
								if ($label->label_style == 'rotated' && !($label->enable_image && $label->label_image))
								{
									?>
									<div class="cut-rotated">
									<?php
								}
								if ($label->enable_image && $label->label_image)
								{
									$imageWidth = $label->label_image_width > 0 ? $label->label_image_width : EshopHelper::getConfigValue('label_image_width');
									if (!$imageWidth)
										$imageWidth = 50;
									$imageHeight = $label->label_image_height > 0 ? $label->label_image_height : EshopHelper::getConfigValue('label_image_height');
									if (!$imageHeight)
										$imageHeight = 50;
									?>
									<span class="horizontal <?php echo $label->label_position; ?> small-db" style="opacity: <?php echo $label->label_opacity; ?>;<?php echo 'background-image: url(' . $label->label_image . ')'; ?>; background-repeat: no-repeat; width: <?php echo $imageWidth; ?>px; height: <?php echo $imageHeight; ?>px; box-shadow: none;"></span>
									<?php
								}
								else
								{
									?>
									<span class="<?php echo $label->label_style; ?> <?php echo $label->label_position; ?> small-db" style="background-color: <?php echo '#'.$label->label_background_color; ?>; color: <?php echo '#'.$label->label_foreground_color; ?>; opacity: <?php echo $label->label_opacity; ?>;<?php if ($label->label_bold) echo 'font-weight: bold;'; ?>">
										<?php echo $label->label_name; ?>
									</span>
									<?php
								}
								if ($label->label_style == 'rotated' && !($label->enable_image && $label->label_image))
								{
									?>
									</div>
									<?php
								}
							}
						}
						?>
						<img src="<?php echo $this->item->thumb_image; ?>" title="<?php echo $this->item->product_page_title != '' ? $this->item->product_page_title : $this->item->product_name; ?>" alt="<?php echo $this->item->product_alt_image != '' ? $this->item->product_alt_image : $this->item->product_name; ?>" />
					</a>
				</div>
				<?php
				if (count($this->productImages) > 0)
				{
					?>
					<div class="image-additional">
						<?php
						for ($i = 0; $n = count($this->productImages), $i < $n; $i++)
						{
							?>
							<div>
								<a class="product-image" href="<?php echo $this->productImages[$i]->popup_image; ?>">
									<img src="<?php echo $this->productImages[$i]->small_thumb_image; ?>" title="<?php echo $this->item->product_page_title != '' ? $this->item->product_page_title : $this->item->product_name; ?>" alt="<?php echo $this->item->product_alt_image != '' ? $this->item->product_alt_image : $this->item->product_name; ?>" />
								</a>
							</div>
							<?php
						}
						?>
					</div>
					<?php
				}
			}
			?>
		</div>
		<div class="<?php echo $infoSpanClass; ?>">
    		<?php
    		if (EshopHelper::getConfigValue('show_manufacturer') || EshopHelper::getConfigValue('show_sku') || EshopHelper::getConfigValue('show_availability') || EshopHelper::getConfigValue('show_product_weight') || EshopHelper::getConfigValue('show_product_dimensions') || (EshopHelper::getConfigValue('show_product_tags') && count($this->productTags)) || (EshopHelper::getConfigValue('show_product_attachments') && count($this->productAttachments)) || (isset($this->item->paramData) && count($this->item->paramData)))
			{
    			?>
    			<div>
                    <div class="product-desc">
                    	<?php
                    	if (EshopHelper::getConfigValue('show_manufacturer'))
						{
                    		?>
                    		<div class="product-manufacturer">
                        		<strong><?php echo JText::_('ESHOP_BRAND'); ?>:</strong>
                        		<span>
                        			<?php
                        			if (isset($this->manufacturer->manufacturer_name))
                        			{
                        			    ?>
                        			    <a href="<?php echo JRoute::_(EshopRoute::getManufacturerRoute($this->manufacturer->id)); ?>"><?php echo $this->manufacturer->manufacturer_name; ?></a>
                        			    <?php
                        			}
                        			?>
                        		</span>
                        	</div>
                        	<?php
                    	}
                    	?>
                    	<div id="product-dynamic-info">
                        	<?php
                        	if (EshopHelper::getConfigValue('show_sku'))
    						{
                        		?>
                        		<div class="product-sku">
                            		<strong><?php echo JText::_('ESHOP_PRODUCT_CODE'); ?>:</strong>
                            		<span><?php echo $this->item->product_sku; ?></span>
                            	</div>
                        		<?php
                        	}
                        	if (EshopHelper::getConfigValue('show_availability'))
    						{
                        		?>
                        		<div class="product-availability">
                            		<strong><?php echo JText::_('ESHOP_AVAILABILITY'); ?>:</strong>
                            		<span>
                            			<?php
                            			echo $this->item->availability;
                            			if (isset($this->product_available_date))
    									{
                            				echo ' (' . JText::_('ESHOP_PRODUCT_AVAILABLE_DATE') . ': ' . $this->product_available_date . ')';
                            			}
                            			?>
                            		</span>
                            	</div>
                        		<?php
                        	}
                        	if (EshopHelper::getConfigValue('show_product_weight'))
                        	{
                        		?>
    							<div class="product-weight">
    								<strong><?php echo JText::_('ESHOP_PRODUCT_WEIGHT'); ?>:</strong>
    								<span><?php echo number_format($this->item->product_weight, 2).EshopHelper::getWeightUnit($this->item->product_weight_id, JFactory::getLanguage()->getTag()); ?></span>
    							</div>
    							<?php
    						}
    						?>
    					</div>
    					<?php
						if (EshopHelper::getConfigValue('show_product_dimensions'))
						{
							?>
							<div class="product-dimensions">
								<strong><?php echo JText::_('ESHOP_PRODUCT_DIMENSIONS'); ?>:</strong>
								<span><?php echo number_format($this->item->product_length, 2).EshopHelper::getLengthUnit($this->item->product_length_id, JFactory::getLanguage()->getTag()) . ' x ' . number_format($this->item->product_width, 2).EshopHelper::getLengthUnit($this->item->product_length_id, JFactory::getLanguage()->getTag()) . ' x ' . number_format($this->item->product_height, 2).EshopHelper::getLengthUnit($this->item->product_length_id, JFactory::getLanguage()->getTag()); ?></span>
							</div>
							<?php
						}
						if (EshopHelper::getConfigValue('show_product_tags') && count($this->productTags))
						{
							?>
							<div class="product-tags">
								<strong><?php echo JText::_('ESHOP_PRODUCT_TAGS'); ?>:</strong>
								<span>
									<?php
									for ($i = 0; $n = count($this->productTags), $i < $n; $i++)
									{
										$tagName = trim($this->productTags[$i]->tag_name);
										$searchTagLink = JRoute::_(EshopRoute::getViewRoute('search') . '&keyword=' . $tagName, false);
										?>
											<a href="<?php echo $searchTagLink; ?>" title="<?php echo $tagName; ?>"><?php echo $tagName; ?></a>
										<?php
										if ($i < ($n - 1))
											echo ", ";
									}
									?>
								</span>
							</div>
							<?php
						}
						if (EshopHelper::getConfigValue('show_product_attachments') && count($this->productAttachments) > 0)
						{
							?>
							<div class="product-attachments">
								<strong><?php echo JText::_('ESHOP_PRODUCT_ATTACHMENTS'); ?>:</strong>
								<br />
								<span>
									<?php
									for ($i = 0; $n = count($this->productAttachments), $i < $n; $i++)
									{
										$productAttachment = $this->productAttachments[$i]->file_name;
										?>
										- <a href="<?php echo JURI::root().'media/com_eshop/attachments/'.$productAttachment; ?>" title="<?php echo $productAttachment; ?>" target="_blank"><?php echo $productAttachment; ?></a>
										<br />
									<?php } ?>
								</span>
							</div>
							<?php
						}
						if (isset($this->item->paramData) && count($this->item->paramData)) :
							?>
							<div class="product-extra-information">
                <table class="eshop-product-extrafiled-table">
                  <tbody>
                    <?php foreach ($this->item->paramData as $param) : ?>
                      <?php if ($param['value']): ?>
                      <tr>
                        <td><?php echo $param['title']; ?></td>
                        <td><?php echo $param['value']; ?></td>
                      </tr>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </tbody>
                </table>
							</div>
            <?php endif; ?>
          </div>
        </div>
    			<?php
    		}
        ?>

        <?php if (EshopHelper::showPrice() && !$this->item->product_call_for_price) : ?>
          <div>
            <div class="product-price" id="product-price">
              <h2>
                <strong>
                  <?php echo JText::_('ESHOP_PRICE'); ?>:
                  <?php $productPriceArray = EshopHelper::getProductPriceArray($this->item->id, $this->item->product_price); ?>
                  <span class="price-contain">
                    <?php if ($productPriceArray['salePrice'] >= 0) : ?>
                      <span class="eshop-base-price"><?php echo $this->currency->format($this->tax->calculate($productPriceArray['basePrice'], $this->item->product_taxclass_id, EshopHelper::getConfigValue('tax'))); ?></span>&nbsp;
                      <span class="eshop-sale-price"><?php echo $this->currency->format($this->tax->calculate($productPriceArray['salePrice'], $this->item->product_taxclass_id, EshopHelper::getConfigValue('tax'))); ?></span>
                    <?php else: ?>
                      <span class="price"><?php echo $this->currency->format($this->tax->calculate($productPriceArray['basePrice'], $this->item->product_taxclass_id, EshopHelper::getConfigValue('tax'))); ?></span>
                    <?php endif; ?>
                  </span>
                </strong>
              </h2>
              <?php if (EshopHelper::getConfigValue('tax') && EshopHelper::getConfigValue('display_ex_tax')) : ?>
              	<small>
                  <?php echo JText::_('ESHOP_EX_TAX'); ?>:
                  <?php if ($productPriceArray['salePrice'] >= 0) : ?>
                    <?php echo $this->currency->format($productPriceArray['salePrice']); ?>
                  <?php else: ?>
                    <?php echo $this->currency->format($productPriceArray['basePrice']); ?>
                  <?php endif; ?>
                </small>
              <?php endif; ?>
            </div>
          </div>
          <?php if (count($this->discountPrices)) : ?>
            <div>
              <div class="product-discount-price">
                <?php for ($i = 0; $n = count($this->discountPrices), $i < $n; $i++) : ?>
                  <?php $discountPrices = $this->discountPrices[$i]; ?>
                  <?php echo $discountPrices->quantity.' '.JText::_('ESHOP_OR_MORE').' '.$this->currency->format($this->tax->calculate($discountPrices->price, $this->item->product_taxclass_id, EshopHelper::getConfigValue('tax'))).'<br />'; ?>
                <?php endfor; ?>
              </div>
            </div>
          <?php endif; ?>
        <?php endif; ?>

        <div class="product-add-cart clearfix">
        	<?php if (EshopHelper::isCartMode($this->item) || EshopHelper::isQuoteMode($this->item)) : ?>
            <div class="eshop-cart-area">
            	<input type="hidden" name="id" value="<?php echo $this->item->id; ?>" />
            	<?php if (EshopHelper::getConfigValue('show_quantity_box_in_product_page')) : ?>
                <div class="input-group quantity-box">
                  <div class="input-group-prepend">
                    <a onclick="quantityUpdate('-', 'quantity_<?php echo $this->item->id; ?>', <?php echo EshopHelper::getConfigValue('quantity_step', '1'); ?>)" class="btn btn-outline-primary btn-default button-minus" id="<?php echo $this->item->id; ?>">-</a>
                  </div>
                  <input type="text" class="form-control eshop-quantity-value" id="quantity_<?php echo $this->item->id; ?>" name="quantity" value="<?php echo EshopHelper::getConfigValue('start_quantity_number', '1'); ?>" />
                  <div class="input-group-append">
                    <a onclick="quantityUpdate('+', 'quantity_<?php echo $this->item->id; ?>', <?php echo EshopHelper::getConfigValue('quantity_step', '1'); ?>)" class="btn btn-outline-primary btn-default button-plus" id="<?php echo $this->item->id; ?>">+</a>
                  </div>
                </div>
              <?php endif; ?>
  						<?php if (EshopHelper::isCartMode($this->item)) : ?>
  							<button id="add-to-cart" class="btn btn-primary" type="button"><?php echo JText::_('ESHOP_ADD_TO_CART'); ?></button>
              <?php endif; ?>
  						<?php if (EshopHelper::isQuoteMode($this->item)) : ?>
  							<button id="add-to-quote" class="btn btn-primary" type="button"><?php echo JText::_('ESHOP_ADD_TO_QUOTE'); ?></button>
              <?php endif; ?>
  					</div>
          <?php endif; ?>
      	</div>

        <div class="eshop-product-attributes">
          <table class="eshop-product-attributes-table">
      			<?php for ($i = 0; $n = count($this->attributeGroups), $i < $n; $i++) : ?>
      				<?php if (count($this->productAttributes[$i])) : ?>
      					<thead>
      						<tr>
      							<th colspan="2"><?php echo $this->attributeGroups[$i]->attributegroup_name; ?></th>
      						</tr>
      					</thead>
      					<tbody>
      						<?php for ($j = 0; $m = count($this->productAttributes[$i]), $j < $m; $j++) : ?>
      							<tr>
      								<td><?php echo $this->productAttributes[$i][$j]->attribute_name; ?></td>
      								<td><?php echo $this->productAttributes[$i][$j]->value; ?></td>
      							</tr>
                  <?php endfor; ?>
      					</tbody>
              <?php endif; ?>
            <?php endfor; ?>
          	</table>
        </div>

      <div class="product-buttons clearfix">
        <?php if (($this->item->product_quantity <= 0 && EshopHelper::getConfigValue('allow_notify') && !EshopHelper::getConfigValue('stock_checkout')) || EshopHelper::getConfigValue('allow_wishlist') || EshopHelper::getConfigValue('allow_compare') || EshopHelper::getConfigValue('allow_ask_question') || EshopHelper::getConfigValue('allow_download_pdf_product') || EshopHelper::getConfigValue('allow_email_to_a_friend')) : ?>
            <?php if ($this->item->product_quantity <= 0 && EshopHelper::getConfigValue('allow_notify') && !EshopHelper::getConfigValue('stock_checkout')) : ?>
              <a class="btn btn-outline-secondary" style="cursor: pointer;" onclick="makeNotify(<?php echo $this->item->id; ?>, '<?php echo EshopHelper::getSiteUrl();?>', '<?php echo EshopHelper::getAttachedLangLink(); ?>')" >
                <i class="fas fa-bell"></i>
  							<span><?php echo JText::_('ESHOP_PRODUCT_NOTIFY');?></span>
              </a>
            <?php endif; ?>
            <?php if (EshopHelper::getConfigValue('allow_wishlist')) : ?>
              <a class="btn btn-outline-secondary" style="cursor: pointer;" onclick="addToWishList(<?php echo $this->item->id; ?>, '<?php echo EshopHelper::getSiteUrl(); ?>', '<?php echo EshopHelper::getAttachedLangLink(); ?>')">
                <i class="fas fa-heart"></i>
  							<span><?php echo JText::_('ESHOP_ADD_TO_WISH_LIST'); ?></span>
              </a>
            <?php endif; ?>
            <?php if (EshopHelper::getConfigValue('allow_compare')) : ?>
              <a class="btn btn-outline-secondary" style="cursor: pointer;" onclick="addToCompare(<?php echo $this->item->id; ?>, '<?php echo EshopHelper::getSiteUrl(); ?>', '<?php echo EshopHelper::getAttachedLangLink(); ?>')">
                <i class="fas fa-copy"></i>
  							<span><?php echo JText::_('ESHOP_ADD_TO_COMPARE'); ?></span>
              </a>
            <?php endif; ?>
            <?php if (EshopHelper::getConfigValue('allow_ask_question')) : ?>
              <a class="btn btn-outline-secondary" style="cursor: pointer;" onclick="askQuestion(<?php echo $this->item->id; ?>, '<?php echo EshopHelper::getSiteUrl(); ?>', '<?php echo EshopHelper::getAttachedLangLink(); ?>')">
                <i class="fas fa-question"></i>
                <span><?php echo JText::_('ESHOP_ASK_QUESTION'); ?></span>
              </a>
            <?php endif; ?>
            <?php if (EshopHelper::getConfigValue('allow_email_to_a_friend')) : ?>
              <a class="btn btn-outline-secondary" style="cursor: pointer;" onclick="emailAFriend(<?php echo $this->item->id; ?>, '<?php echo EshopHelper::getSiteUrl(); ?>', '<?php echo EshopHelper::getAttachedLangLink(); ?>')">
                <i class="fas fa-share"></i>
                <span><?php echo JText::_('ESHOP_EMAIL_A_FRIEND'); ?></span>
              </a>
            <?php endif; ?>
            <?php if (EshopHelper::getConfigValue('allow_download_pdf_product')) : ?>
              <a class="btn btn-outline-secondary" style="cursor: pointer;" href="index.php?option=com_eshop&task=product.downloadPDF&product_id=<?php echo $this->item->id; ?>">
                <i class="fas fa-file-pdf"></i>
                <span><?php echo JText::_('ESHOP_DOWNLOAD_PDF_PRODUCT'); ?></span>
              </a>
            <?php endif; ?>
        <?php endif; ?>
      </div>

      <?php if ($this->item->product_call_for_price) : ?>
				<div>
					<div class="product-price">
						<?php echo JText::_('ESHOP_CALL_FOR_PRICE'); ?>: <?php echo EshopHelper::getConfigValue('telephone'); ?>
					</div>
				</div>
      <?php endif; ?>

      <?php if (count($this->productOptions)) : ?>
        <div>
          <div class="product-options">
            <h2>
              <?php echo JText::_('ESHOP_AVAILABLE_OPTIONS'); ?>
            </h2>
            <?php for ($i = 0; $n = count($this->productOptions), $i < $n; $i++) : ?>
              <?php $option = $this->productOptions[$i]; ?>
              <?php if (!EshopHelper::isCartMode($this->item) && !EshopHelper::isQuoteMode($this->item) && ($option->option_type == 'Text' || $option->option_type == 'Textarea' || $option->option_type == 'File' || $option->option_type == 'Date' || $option->option_type == 'Datetime')) : ?>
              	<?php continue; ?>
              <?php endif; ?>
              <div id="option-<?php echo $option->product_option_id; ?>">
								<div>
									<?php if ($option->required && (EshopHelper::isCartMode($this->item) || EshopHelper::isQuoteMode($this->item))) : ?>
                    <span class="required">*</span>
                  <?php endif; ?>
                  <strong><?php echo $option->option_name; ?>:</strong>
                  <?php if ($option->option_type == 'File') : ?>
                  	<span id="file-<?php echo $option->product_option_id; ?>"></span>
                  <?php endif; ?>
                  <?php if ($option->option_desc != '') : ?>
                  	<p><?php echo $option->option_desc; ?></p>
                  <?php else: ?>
                  	<br/>
                  <?php endif; ?>
									<?php echo EshopOption::renderOption($this->item->id, $option->id, $option->option_type, $this->item->product_taxclass_id); ?>
								</div>
              </div>
            <?php endfor; ?>
          </div>
        </div>
      <?php endif; ?>

      <?php if (EshopHelper::getConfigValue('allow_reviews')) : ?>
      	<div>
          <div class="product-review">
            <p class="mb-0">
              <img src="components/com_eshop/assets/images/stars-<?php echo round(EshopHelper::getProductRating($this->item->id)); ?>.png" />
              <a onclick="activeReviewsTab();" style="cursor: pointer;"><?php echo count($this->productReviews).' '.JText::_('ESHOP_REVIEWS'); ?></a> | <a onclick="activeReviewsTab();" style="cursor: pointer;"><i class="far fa-edit"></i> <?php echo JText::_('ESHOP_WRITE_A_REVIEW'); ?></a>
            </p>
          </div>
        </div>
      <?php endif; ?>

      <?php if (EshopHelper::getConfigValue('social_enable')) : ?>
      	<div>
					<div class="product-share">
						<div class="ps_area clearfix">
							<?php if (EshopHelper::getConfigValue('show_facebook_button')) : ?>
								<div class="ps_facebook_like">
									<div class="fb-like" data-send="true" data-width="<?php echo EshopHelper::getConfigValue('button_width', 450); ?>" data-show-faces="<?php echo EshopHelper::getConfigValue('show_faces', 1); ?>" vdata-font="<?php echo EshopHelper::getConfigValue('button_font', 'arial'); ?>" data-colorscheme="<?php echo EshopHelper::getConfigValue('button_theme', 'light'); ?>" layout="<?php echo EshopHelper::getConfigValue('button_layout', 'button_count'); ?>"></div>
								</div>
              <?php endif; ?>
							<?php if (EshopHelper::getConfigValue('show_twitter_button')) : ?>
								<div class="ps_twitter">
									<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $uri->toString(); ?>" tw:via="ontwiik" data-lang="en" data-related="anywhereTheJavascriptAPI" data-count="horizontal">Tweet</a>
								</div>
              <?php endif; ?>
							<?php if (EshopHelper::getConfigValue('show_pinit_button')) : ?>
								<div class="ps_pinit">
									<a href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode($uri->toString()); ?>&media=<?php echo urlencode(EshopHelper::getSiteUrl().$this->item->thumb_image); ?>&description=<?php echo $this->item->product_name; ?>" count-layout="horizontal" class="pin-it-button">Pin It</a>
								</div>
              <?php endif; ?>
							<?php if (EshopHelper::getConfigValue('show_linkedin_button')) : ?>
								<div class="ps_linkedin">
									<?php if (EshopHelper::getConfigValue('linkedin_layout', 'right') == 'no-count') : ?>
										<script type="IN/Share"></script>
                  <?php else: ?>
										<script type="IN/Share" data-counter="<?php echo EshopHelper::getConfigValue('linkedin_layout', 'right'); ?>"></script>
                  <?php endif; ?>
								</div>
              <?php endif; ?>
							<?php if (EshopHelper::getConfigValue('show_google_button')) : ?>
								<div class="ps_google">
									<div class="g-plusone"></div>
								</div>
              <?php endif; ?>
						</div>
					</div>
				</div>
      <?php endif; ?>

		</div>

  </div>
	<?php
	echo JHtml::_('bootstrap.startTabSet', 'product', array('active' => 'description'));

	echo JHtml::_('bootstrap.addTab', 'product', 'description', JText::_('ESHOP_DESCRIPTION', true));
	echo $this->item->product_desc;
	echo JHtml::_('bootstrap.endTab');

	if ($this->item->tab1_title != '' && $this->item->tab1_content != '')
	{
	    echo JHtml::_('bootstrap.addTab', 'product', 'tab1-content', $this->item->tab1_title);
	    echo $this->item->tab1_content;
	    echo JHtml::_('bootstrap.endTab');
	}

	if ($this->item->tab2_title != '' && $this->item->tab2_content != '')
	{
	    echo JHtml::_('bootstrap.addTab', 'product', 'tab2-content', $this->item->tab2_title);
	    echo $this->item->tab2_content;
	    echo JHtml::_('bootstrap.endTab');
	}

	if ($this->item->tab3_title != '' && $this->item->tab3_content != '')
	{
	    echo JHtml::_('bootstrap.addTab', 'product', 'tab3-content', $this->item->tab3_title);
	    echo $this->item->tab3_content;
	    echo JHtml::_('bootstrap.endTab');
	}

	if ($this->item->tab4_title != '' && $this->item->tab4_content != '')
	{
	    echo JHtml::_('bootstrap.addTab', 'product', 'tab4-content', $this->item->tab4_title);
	    echo $this->item->tab4_content;
	    echo JHtml::_('bootstrap.endTab');
	}

	if ($this->item->tab5_title != '' && $this->item->tab5_content != '')
	{
	    echo JHtml::_('bootstrap.addTab', 'product', 'tab5-content', $this->item->tab5_title);
	    echo $this->item->tab5_content;
	    echo JHtml::_('bootstrap.endTab');
	}

	if (EshopHelper::getConfigValue('show_specification') && $this->hasSpecification)
	{
	    echo JHtml::_('bootstrap.addTab', 'product', 'specification', JText::_('ESHOP_SPECIFICATION', true));
	    ?>
		<table class="table table-bordered">
			<?php
			for ($i = 0; $n = count($this->attributeGroups), $i < $n; $i++)
			{
				if (count($this->productAttributes[$i]))
				{
					?>
					<thead>
						<tr>
							<th colspan="2"><?php echo $this->attributeGroups[$i]->attributegroup_name; ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						for ($j = 0; $m = count($this->productAttributes[$i]), $j < $m; $j++)
						{
							?>
							<tr>
								<td width="30%"><?php echo $this->productAttributes[$i][$j]->attribute_name; ?></td>
								<td width="70%"><?php echo $this->productAttributes[$i][$j]->value; ?></td>
							</tr>
							<?php
						}
						?>
					</tbody>
					<?php
				}
				?>
    			<?php
    		}
    		?>
    	</table>
        <?php
        echo JHtml::_('bootstrap.endTab');
    }

    if (EshopHelper::getConfigValue('allow_reviews'))
    {
        echo JHtml::_('bootstrap.addTab', 'product', 'reviews', JText::_('ESHOP_REVIEWS') . ' (' . count($this->productReviews) . ')');

        if (count($this->productReviews) > 5)
        {
            ?>
    		<div class="<?php echo $span12Class; ?> pagination pagination-toolbar" style="text-align: right; margin-top: 20px;">
    			<ul class="review-pagination-list"></ul>
    		</div>
       	 	<?php
    	}
     	?>
    	<div id="wrap-review">
    		<?php
    		if (count($this->productReviews))
    		{
    			foreach ($this->productReviews as $review)
    			{
    				?>
    				<div class="review-list">
    					<div class="author"><b><?php echo $review->author; ?></b> <?php echo JText::_('ESHOP_REVIEW_ON'); ?> <?php echo JHtml::date($review->created_date, EshopHelper::getConfigValue('date_format', 'm-d-Y') . ' h:i A'); ?></div>
    					<div class="rating"><img src="components/com_eshop/assets/images/stars-<?php echo $review->rating . '.png'; ?>" alt="" /></div>
    					<div class="text"><?php echo nl2br($review->review); ?></div>
    				</div>
    				<?php
    			}
    		}
    		else
    		{
    			?>
    			<div class="no-content"><?php echo JText::_('ESHOP_NO_PRODUCT_REVIEWS'); ?></div>
    			<?php
    		}
    		?>
    	</div>
    	<div class="clearfix"></div>
		<legend id="review-title"><?php echo JText::_('ESHOP_WRITE_A_REVIEW'); ?></legend>
		<div class="<?php echo $controlGroupClass; ?>">
			<label class="<?php echo $controlLabelClass; ?>" for="author"><span class="required">*</span><?php echo JText::_('ESHOP_YOUR_NAME'); ?>:</label>
			<div class="<?php echo $controlsClass; ?> docs-input-sizes">
				<input type="text" class="input-large" name="author" id="author" value="" />
			</div>
		</div>
		<div class="<?php echo $controlGroupClass; ?>">
			<label class="<?php echo $controlLabelClass; ?>" for="author"><span class="required">*</span><?php echo JText::_('ESHOP_YOUR_REVIEW'); ?>:</label>
			<div class="<?php echo $controlsClass; ?> docs-input-sizes">
				<textarea rows="5" cols="40" name="review"></textarea>
			</div>
		</div>
		<div class="<?php echo $controlGroupClass; ?>">
			<label class="<?php echo $controlLabelClass; ?>" for="author"><span class="required">*</span><?php echo JText::_('ESHOP_RATING'); ?>:</label>
			<div class="<?php echo $controlsClass; ?> docs-input-sizes">
				<?php echo $this->ratingHtml; ?>
			</div>
		</div>
		<?php
		if ($this->showCaptcha)
		{
		    if ($this->captchaPlugin == 'recaptcha_invisible')
		    {
		        $style = ' style="display:none;"';
		    }
		    else
		    {
		        $style = '';
		    }
			?>
			<div class="<?php echo $controlGroupClass; ?>"<?php echo $style; ?>>
				<div class="<?php echo $controlLabelClass; ?>">
					<?php echo JText::_('ESHOP_CAPTCHA'); ?>
					<span class="required">*</span>
				</div>
				<div class="<?php echo $controlsClass; ?>">
					<?php echo $this->captcha; ?>
				</div>
			</div>
			<?php
		}
		?>
		<input type="button" class="btn btn-primary" id="button-review" value="<?php echo JText::_('ESHOP_SUBMIT'); ?>" />
		<input type="hidden" name="product_id" value="<?php echo $this->item->id; ?>" />
    	<?php
    	if (EshopHelper::getConfigValue('show_facebook_comment'))
    	{
    		?>
    		<div class="row-fluild">
    			<legend id="review-title"><?php echo JText::_('ESHOP_FACEBOOK_COMMENT'); ?></legend>
    			<div class="fb-comments" data-num-posts="<?php echo EshopHelper::getConfigValue('num_posts', 10); ?>" data-width="<?php echo EshopHelper::getConfigValue('comment_width', 400); ?>" data-href="<?php echo $uri->toString(); ?>"></div>
    		</div>
    		<?php
    	}
        echo JHtml::_('bootstrap.endTab');
    }

    if (EshopHelper::getConfigValue('show_related_products') && count($this->productRelations))
    {
        echo JHtml::_('bootstrap.addTab', 'product', 'related-products', JText::_('ESHOP_RELATED_PRODUCTS', true));
        ?>
        <div class="related_products <?php echo $rowFluidClass; ?>">
    		<?php
    		for ($i = 0; $n = count($this->productRelations), $i < $n; $i++)
    		{
    			$productRelation = $this->productRelations[$i];
    			?>
    			<div class="<?php echo $span3Class; ?>">
    				<div class="image <?php echo $imgPolaroid; ?>">
            			<a href="<?php echo JRoute::_(EshopRoute::getProductRoute($productRelation->id, EshopHelper::getProductCategory($productRelation->id))); ?>">
            				<span class="related-product-image">
            					<img src="<?php echo $productRelation->thumb_image; ?>" title="<?php echo $productRelation->product_page_title != '' ? $productRelation->product_page_title : $productRelation->product_name; ?>" alt="<?php echo $productRelation->product_alt_image != '' ? $productRelation->product_alt_image : $productRelation->product_name; ?>" />
            				</span>
            				<?php
							if (isset($productRelation->additional_image) && EshopHelper::getConfigValue('product_image_rollover', 0))
							{
							    ?>
								<span class="additional-image">
									<img src="<?php echo $productRelation->additional_image; ?>" title="<?php echo $productRelation->product_page_title != '' ? $productRelation->product_page_title : $productRelation->product_name; ?>" alt="<?php echo $productRelation->product_alt_image != '' ? $productRelation->product_alt_image : $productRelation->product_name; ?>" />
								</span>
								<?php
							}
							?>
                		</a>
					</div>
                    <div class="name">
                        <a href="<?php echo JRoute::_(EshopRoute::getProductRoute($productRelation->id, EshopHelper::getProductCategory($productRelation->id))); ?>">
                            <h5><?php echo $productRelation->product_name; ?></h5>
                        </a>
                        <?php
                        if (EshopHelper::showPrice() && !$productRelation->product_call_for_price)
                        {
                            echo JText::_('ESHOP_PRICE'); ?>:
                            <?php
                            $productRelationPriceArray = EshopHelper::getProductPriceArray($productRelation->id, $productRelation->product_price);
                            if ($productRelationPriceArray['salePrice'] >= 0)
                            {
                                ?>
                                <span class="eshop-base-price"><?php echo $this->currency->format($this->tax->calculate($productRelationPriceArray['basePrice'], $productRelation->product_taxclass_id, EshopHelper::getConfigValue('tax'))); ?></span>&nbsp;
                                <span class="eshop-sale-price"><?php echo $this->currency->format($this->tax->calculate($productRelationPriceArray['salePrice'], $productRelation->product_taxclass_id, EshopHelper::getConfigValue('tax'))); ?></span>
                                <?php
                            }
                            else
                            {
                                ?>
                                <span class="price"><?php echo $this->currency->format($this->tax->calculate($productRelationPriceArray['basePrice'], $productRelation->product_taxclass_id, EshopHelper::getConfigValue('tax'))); ?></span>
                                <?php
                            }
                        }
                        if ($productRelation->product_call_for_price)
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
					</div><div class="related_products <?php echo $rowFluidClass; ?>">
					<?php
				}
			}
			?>
		</div>
        <?php
	    echo JHtml::_('bootstrap.endTab');
	}

	if (count($this->plugins))
	{
	    foreach ($this->plugins as $plugin)
	    {
	        if (is_array($plugin) && array_key_exists('name', $plugin) && array_key_exists('title', $plugin) && array_key_exists('form', $plugin))
	        {
	            echo JHtml::_('bootstrap.addTab', 'product', $plugin['name'], $plugin['title']);
	            echo $plugin['form'];
	            echo JHtml::_('bootstrap.endTab');
	        }
	    }
	}

	echo JHtml::_('bootstrap.endTabSet');
	?>
</div>
<input type="hidden" name="review-tab" id="review-tab" value="0" />
<script type="text/javascript">
	// Add to cart button
	Eshop.jQuery(function($){

		$("ul#productTab li a").on('shown.bs.tab', function (e) {
			var isTab = $(this).attr('href');
			var reviewTab = $('#review-tab').val();
			if(isTab == '#reviews' && reviewTab == 0)
			{
				$('#review-tab').val(1);
				loadReviewPagination();
			}
		});
		loadReviewPagination = (function(){
			 $(".review-pagination-list").eshopPagination({
				 containerID: "wrap-review",
				 perPage: 5,
			 });
		})

		$('#add-to-cart').bind('click', function() {
			var siteUrl = '<?php echo EshopHelper::getSiteUrl(); ?>';
			$.ajax({
				type: 'POST',
				url: siteUrl + 'index.php?option=com_eshop&task=cart.add<?php echo EshopHelper::getAttachedLangLink(); ?>',
				data: $('.product-info input[type=\'text\'], .product-info input[type=\'hidden\'], .product-info input[type=\'radio\']:checked, .product-info input[type=\'checkbox\']:checked, .product-info select, .product-info textarea'),
				dataType: 'json',
				beforeSend: function() {
					$('#add-to-cart').attr('disabled', true);
					$('#add-to-cart').after('<span class="wait">&nbsp;<img src="components/com_eshop/assets/images/loading.gif" alt="" /></span>');
				},
				complete: function() {
					$('#add-to-cart').attr('disabled', false);
					$('.wait').remove();
				},
				success: function(json) {
					$('.error').remove();
					if (json['error']) {
						if (json['error']['option']) {
							for (i in json['error']['option']) {
								$('#option-' + i).after('<span class="error">' + json['error']['option'][i] + '</span>');
							}
						}
					}
					if (json['success']) {
						<?php
						if (EshopHelper::getConfigValue('cart_popout', 'popout') == 'message')
						{
						    $message = EshopHelper::getCartSuccessMessage($this->item->id, $this->item->product_name);
                            ?>
                            $.ajax({
								url: siteUrl + 'index.php?option=com_eshop&view=cart&layout=mini&format=raw<?php echo EshopHelper::getAttachedLangLink(); ?>&pt=' + json['time'],
								dataType: 'html',
								success: function(html) {
									$('#eshop-cart').html(html);
									$('.eshop-content').hide();
									$('.alert-success').remove();
                                    $('.product-cart').before('<div class="alert-success"><?php echo $message; ?></div>');
								},
								error: function(xhr, ajaxOptions, thrownError) {
									alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
								}
							});
                            <?php
						}
						elseif (EshopHelper::getConfigValue('cart_popout', 'popout') == 'redirect')
						{
						    ?>
    						window.location.href = '<?php echo JRoute::_(EshopRoute::getViewRoute('cart')); ?>';
    						<?php
						}
						else
						{
							?>
							$.ajax({
								url: siteUrl + 'index.php?option=com_eshop&view=cart&layout=popout&format=raw<?php echo EshopHelper::getAttachedLangLink(); ?>&pt=' + json['time'],
								dataType: 'html',
								success: function(html) {
									$.colorbox({
										overlayClose: true,
										opacity: 0.5,
										href: false,
										html: html
									});
									$.ajax({
										url: siteUrl + 'index.php?option=com_eshop&view=cart&layout=mini&format=raw<?php echo EshopHelper::getAttachedLangLink(); ?>&pt=' + json['time'],
										dataType: 'html',
										success: function(html) {
											$('#eshop-cart').html(html);
											$('.eshop-content').hide();
										},
										error: function(xhr, ajaxOptions, thrownError) {
											alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
										}
									});
								},
								error: function(xhr, ajaxOptions, thrownError) {
									alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
								}
							});
							<?php
						}
						?>
					}
			  	},
			  	error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});
		$('#add-to-quote').bind('click', function() {
			var siteUrl = '<?php echo EshopHelper::getSiteUrl(); ?>';
			$.ajax({
				type: 'POST',
				url: siteUrl + 'index.php?option=com_eshop&task=quote.add<?php echo EshopHelper::getAttachedLangLink(); ?>',
				data: $('.product-info input[type=\'text\'], .product-info input[type=\'hidden\'], .product-info input[type=\'radio\']:checked, .product-info input[type=\'checkbox\']:checked, .product-info select, .product-info textarea'),
				dataType: 'json',
				beforeSend: function() {
					$('#add-to-quote').attr('disabled', true);
					$('#add-to-quote').after('<span class="wait">&nbsp;<img src="components/com_eshop/assets/images/loading.gif" alt="" /></span>');
				},
				complete: function() {
					$('#add-to-quote').attr('disabled', false);
					$('.wait').remove();
				},
				success: function(json) {
					$('.error').remove();
					if (json['error']) {
						if (json['error']['option']) {
							for (i in json['error']['option']) {
								$('#option-' + i).after('<span class="error">' + json['error']['option'][i] + '</span>');
							}
						}
					}
					if (json['success']) {
						$.ajax({
							url: siteUrl + 'index.php?option=com_eshop&view=quote&layout=popout&format=raw<?php echo EshopHelper::getAttachedLangLink(); ?>&pt=' + json['time'],
							dataType: 'html',
							success: function(html) {
								$.colorbox({
									overlayClose: true,
									opacity: 0.5,
									href: false,
									html: html
								});
								$.ajax({
									url: siteUrl + 'index.php?option=com_eshop&view=quote&layout=mini&format=raw<?php echo EshopHelper::getAttachedLangLink(); ?>&pt=' + json['time'],
									dataType: 'html',
									success: function(html) {
										$('#eshop-quote').html(html);
										$('.eshop-content').hide();
									},
									error: function(xhr, ajaxOptions, thrownError) {
										alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
									}
								});
							},
							error: function(xhr, ajaxOptions, thrownError) {
								alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
							}
						});
					}
			  	}
			});
		});
		// Submit review button
		$('#button-review').bind('click', function() {
			var siteUrl = '<?php echo EshopHelper::getSiteUrl(); ?>';
			$.ajax({
				url: siteUrl + 'index.php?option=com_eshop&task=product.writeReview<?php echo EshopHelper::getAttachedLangLink(); ?>',
				type: 'post',
				dataType: 'json',
				data: $('#reviews input[type=\'text\'], #reviews textarea, #reviews input[type=\'radio\']:checked, #reviews input[type=\'hidden\']'),
				beforeSend: function() {
					$('.success, .warning').remove();
					$('#button-review').attr('disabled', true);
					$('#button-review').after('<span class="wait">&nbsp;<img src="components/com_eshop/assets/images/loading.gif" alt="" /></span>');
				},
				complete: function() {
					$('#button-review').attr('disabled', false);
					$('.wait').remove();
				},
				success: function(data) {
					if (data['error']) {
						$('#review-title').after('<div class="warning">' + data['error'] + '</div>');
					}
					if (data['success']) {
						$('#review-title').after('<div class="success">' + data['success'] + '</div>');
						$('input[name=\'author\']').val('');
						$('textarea[name=\'review\']').val('');
						$('input[name=\'rating\']:checked').attr('checked', '');
					}
				}
			});
		});

		// Function to active reviews tab
		activeReviewsTab = (function(){
			$('#productTabs a[href="#reviews"]').tab('show');
		});
		// Function to update price when options are added
		<?php
		if (EshopHelper::isCartMode($this->item) || EshopHelper::isQuoteMode($this->item))
		{
			?>
			updatePrice = (function(){
				var siteUrl = '<?php echo EshopHelper::getSiteUrl(); ?>';
				$.ajax({
					type: 'POST',
					url: siteUrl + 'index.php?option=com_eshop&view=product&id=<?php echo $this->item->id; ?>&layout=price&format=raw<?php echo EshopHelper::getAttachedLangLink(); ?>',
					data: $('.product-info input[type=\'text\'], .product-info input[type=\'hidden\'], .product-info input[type=\'radio\']:checked, .product-info input[type=\'checkbox\']:checked, .product-info select, .product-info textarea'),
					dataType: 'html',
					success: function(html) {
						$('#product-price').html(html);
					}
				});
			})

			updateInfo = (function(){
    			var siteUrl = '<?php echo EshopHelper::getSiteUrl(); ?>';
    			$.ajax({
    				type: 'POST',
    				url: siteUrl + 'index.php?option=com_eshop&view=product&id=<?php echo $this->item->id; ?>&layout=info&format=raw<?php echo EshopHelper::getAttachedLangLink(); ?>',
    				data: $('.product-info input[type=\'text\'], .product-info input[type=\'hidden\'], .product-info input[type=\'radio\']:checked, .product-info input[type=\'checkbox\']:checked, .product-info select, .product-info textarea'),
    				dataType: 'html',
    				success: function(html) {
    					$('#product-dynamic-info').html(html);
    				}
    			});
    		})
			<?php
		}
		?>

		$(document).ready(function(){
			  $('.image-additional').slick({
				  dots: false,
				  infinite: false,
				  speed: 300,
				  slidesToShow: 3,
				  touchMove: false,
				  slidesToScroll: 1
				});
		});

	})
</script>
<?php
if (count($this->productOptions))
{
	?>
	<script type="text/javascript" src="<?php echo JUri::base(true); ?>/components/com_eshop/assets/js/ajaxupload.js"></script>
	<?php
	foreach ($this->productOptions as $option)
	{
		if ($option->option_type == 'File')
		{
			?>
			<script type="text/javascript">
				new AjaxUpload('#button-option-<?php echo $option->product_option_id; ?>', {
					action: 'index.php',
					name: 'file',
					data: {
						option : 'com_eshop',
						task : 'product.uploadFile'
					},
					autoSubmit: true,
					responseType: 'json',
					onSubmit: function(file, extension) {
						jQuery('#button-option-<?php echo $option->product_option_id; ?>').after('<span class="wait">&nbsp;<img src="components/com_eshop/assets/images/loading.gif" alt="" /></span>');
						jQuery('#button-option-<?php echo $option->product_option_id; ?>').attr('disabled', true);
					},
					onComplete: function(file, json) {
						jQuery('#button-option-<?php echo $option->product_option_id; ?>').attr('disabled', false);
						jQuery('.error').remove();
						if (json['success']) {
							alert(json['success']);
							jQuery('input[name=\'options[<?php echo $option->product_option_id; ?>]\']').attr('value', json['file']);
							jQuery('#file-<?php echo $option->product_option_id; ?>').html(json['file']);
						}
						if (json['error']) {
							jQuery('#option-<?php echo $option->product_option_id; ?>').after('<span class="error">' + json['error'] + '</span>');
						}
						jQuery('.wait').remove();
					}
				});
			</script>
			<?php
		}
	}
}
?>
</section>
