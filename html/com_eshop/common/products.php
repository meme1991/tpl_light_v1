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

$span                   = intval(12 / $productsPerRow);
$rowFluidClass          = $bootstrapHelper->getClassMapping('row-fluid');
$spanClass              = $bootstrapHelper->getClassMapping('span' . $span);
$span3Class             = $bootstrapHelper->getClassMapping('span3');
$span9Class             = $bootstrapHelper->getClassMapping('span9');
$hiddenPhoneClass       = $bootstrapHelper->getClassMapping('hidden-phone');
$inputAppendClass       = $bootstrapHelper->getClassMapping('input-append');
$inputPrependClass      = $bootstrapHelper->getClassMapping('input-prepend');
$imgPolaroid            = $bootstrapHelper->getClassMapping('img-polaroid');
$btnClass				= $bootstrapHelper->getClassMapping('btn');
?>
<script src="<?php echo JUri::base(true); ?>/components/com_eshop/assets/colorbox/jquery.colorbox.js" type="text/javascript"></script>
<script src="<?php echo JUri::base(true); ?>/components/com_eshop/assets/js/jquery.cookie.js" type="text/javascript"></script>
<script src="<?php echo JUri::base(true); ?>/components/com_eshop/assets/js/layout.js" type="text/javascript"></script>
<script>
	Eshop.jQuery(function($){
		$(document).ready(function() {
			changeLayout('<?php echo EshopHelper::getConfigValue('default_products_layout', 'list'); ?>');
		});
	});
</script>
<div id="products-list-container" class="products-list-container block list">
	<div class="sortPagiBar <?php echo $rowFluidClass; ?> clearfix">
		<div class="<?php echo $span3Class; ?>">
			<div class="btn-group">
				<?php if (EshopHelper::getConfigValue('default_products_layout') == 'grid') : ?>
					<a rel="grid" href="#" class="btn btn-link btn-sm"><i class="fas fa-th-large"></i></a>
					<a rel="list" href="#" class="btn btn-link btn-sm"><i class="fas fa-list"></i></a>
				<?php else: ?>
					<a rel="list" href="#" class="btn btn-link btn-sm"><i class="fas fa-list"></i></a>
					<a rel="grid" href="#" class="btn btn-link btn-sm"><i class="fas fa-th-large"></i></a>
				<?php endif ;?>
			</div>
		</div>
		<?php if ($showSortOptions) : ?>
			<div class="<?php echo $span9Class; ?>">
				<form method="post" name="adminForm" id="adminForm" action="<?php echo $actionUrl; ?>">
					<div class="clearfix">
						<div class="eshop-product-show">
							<b><?php echo JText::_('ESHOP_SHOW'); ?>: </b>
							<?php echo $pagination->getLimitBox(); ?>
						</div>
						<?php if ($sort_options) : ?>
							<div class="eshop-product-sorting">
								<b><?php echo JText::_('ESHOP_SORTING_BY'); ?>: </b>
								<?php echo $sort_options; ?>
							</div>
						<?php endif; ?>
					</div>
				</form>
			</div>
		<?php endif; ?>
	</div>
	<div id="products-list" class="clearfix">

		<div class="<?php echo $rowFluidClass; ?> clearfix">
			<?php $count = 0; ?>
			<?php $product_sky_compare = ''; ?>
			<?php foreach ($products as $product) : ?>
				<?php $productUrl = JRoute::_(EshopRoute::getProductRoute($product->id, ($catId && EshopHelper::isProductCategory($product->id, $catId)) ? $catId : EshopHelper::getProductCategory($product->id))); ?>
					<div class="<?php echo $spanClass; ?> ajax-block-product spanbox clearfix">
						<div class="eshop-image-block">
							<div class="image <?php echo $imgPolaroid; ?>">
								<a href="<?php echo $productUrl; ?>" title="<?php echo $product->product_name; ?>">
									<?php
									if (count($product->labels))
									{
										for ($i = 0; $n = count($product->labels), $i < $n; $i++)
										{
											$label = $product->labels[$i];
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
									<span class="product-image">
										<img src="<?php echo $product->image; ?>" title="<?php echo $product->product_page_title != '' ? $product->product_page_title : $product->product_name; ?>" alt="<?php echo $product->product_alt_image != '' ? $product->product_alt_image : $product->product_name; ?>" />
									</span>
									<?php
									if (isset($product->additional_image) && EshopHelper::getConfigValue('product_image_rollover', 0))
									{
									    ?>
										<span class="additional-image">
											<?php echo "<img src='".$product->additional_image."' />"; ?>
										</span>
										<?php
									}
									?>
								</a>
							</div>
						</div>
						<div class="eshop-info-block">
							<?php //$category_details = getCategoryName($product->id); ?>
							<?php //$categoryUrl = JRoute::_(EshopRoute::getCategoryRoute($category_details->category_id));	?>
							<h5 class="eshop-product-name">
								<a href="<?php echo $productUrl; ?>" title="<?php echo $product->product_name; ?>">
									<?php echo $product->product_name;?>
								</a>
							</h5>
							<div class="eshop-product-sku">
								<span><?= $product->product_sku ?></span>
							</div>
							<?php if($product->product_short_desc != '') : ?>
								<div class="eshop-product-desc">
									<?php echo $product->product_short_desc;?>
								</div>
							<?php endif; ?>
							<?php $attributes = getProductAttributes($product->id); ?>
							<?php if($attributes) : ?>
								<div class="eshop-product-attributes">
									<table class="eshop-product-attributes-table table-sm">
										<tbody>
											<?php foreach ($attributes as $k => $attr) : ?>
											<tr>
												<td><?= $attr->attribute_name ?></td>
												<td><?= $attr->value ?></td>
											</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
								</div>
							<?php endif; ?>

							<!-- <?php if($product->paramData): ?>
								<div class="eshop-product-customfields">
									<table class="eshop-product-customfields-table table-sm">
										<tbody>
											<?php foreach ($product->paramData as $k => $filed) : ?>
												<?php if($filed['value'] != '') : ?>
													<tr>
														<td><?= $filed['title'] ?></td>
														<td><?= $filed['value'] ?></td>
													</tr>
												<?php endif; ?>
											<?php endforeach; ?>
										</tbody>
									</table>
								</div>
							<?php endif; ?> -->

							<div class="eshop-product-price">
								<?php if (EshopHelper::showPrice() && !$product->product_call_for_price) : ?>
									<p>
										<?php $productPriceArray = EshopHelper::getProductPriceArray($product->id, $product->product_price); ?>
										<?php if ($productPriceArray['salePrice'] >= 0) : ?>
											<span class="eshop-base-price"><?php echo $currency->format($tax->calculate($productPriceArray['basePrice'], $product->product_taxclass_id, EshopHelper::getConfigValue('tax'))); ?></span>&nbsp;
											<span class="eshop-sale-price"><?php echo $currency->format($tax->calculate($productPriceArray['salePrice'], $product->product_taxclass_id, EshopHelper::getConfigValue('tax'))); ?></span>
										<?php else :?>
											<span class="price"><?php echo $currency->format($tax->calculate($productPriceArray['basePrice'], $product->product_taxclass_id, EshopHelper::getConfigValue('tax'))); ?></span>
										<?php endif; ?>
										<?php if (EshopHelper::getConfigValue('tax') && EshopHelper::getConfigValue('display_ex_tax')) : ?>
											<small>
												<?php echo JText::_('ESHOP_EX_TAX'); ?>:
												<?php if ($productPriceArray['salePrice'] >= 0) : ?>
													<?php echo $currency->format($productPriceArray['salePrice']); ?>
												<?php else : ?>
													<?php echo $currency->format($productPriceArray['basePrice']); ?>
												<?php endif; ?>
											</small>
										<?php endif; ?>
									</p>
								<?php endif; ?>
								<?php if ($product->product_call_for_price) : ?>
									<p><?php echo JText::_('ESHOP_CALL_FOR_PRICE'); ?>: <?php echo EshopHelper::getConfigValue('telephone'); ?></p>
								<?php endif; ?>
							</div>

						</div>
						<div class="eshop-buttons">
							 <?php if (!EshopHelper::isRequiredOptionProduct($product->id)) : ?>
								 <?php if (EshopHelper::isCartMode($product) || EshopHelper::isQuoteMode($product)) : ?>
									<div class="eshop-cart-area">
										<?php if (EshopHelper::getConfigValue('show_quantity_box')) : ?>
											<div class="input-group quantity-box">
											  <div class="input-group-prepend">
													<a onclick="quantityUpdate('-', 'quantity_<?php echo $product->id; ?>', <?php echo EshopHelper::getConfigValue('quantity_step', '1'); ?>)" class="btn btn-outline-primary button-minus" id="<?php echo $product->id; ?>">-</a>
											  </div>
												<input type="text" class="form-control eshop-quantity-value" id="quantity_<?php echo $product->id; ?>" name="quantity[]" value="<?php echo EshopHelper::getConfigValue('start_quantity_number', '1'); ?>" />
												<div class="input-group-append">
													<a onclick="quantityUpdate('+', 'quantity_<?php echo $product->id; ?>', <?php echo EshopHelper::getConfigValue('quantity_step', '1'); ?>)" class="btn btn-outline-primary button-plus" id="<?php echo $product->id; ?>">+</a>
											  </div>
											</div>
										<?php endif; ?>
										<?php if (EshopHelper::isCartMode($product) && !EshopHelper::getConfigValue('one_add_to_cart_button', '0')) : ?>
										   <?php $message = EshopHelper::getCartSuccessMessage($product->id, $product->product_name); ?>
											<input id="add-to-cart-<?php echo $product->id; ?>" type="button" class="btn btn-primary" onclick="addToCart(<?php echo $product->id; ?>, 1, '<?php echo EshopHelper::getSiteUrl(); ?>', '<?php echo EshopHelper::getAttachedLangLink(); ?>', '<?php echo EshopHelper::getConfigValue('cart_popout')?>', '<?php echo JRoute::_(EshopRoute::getViewRoute('cart')); ?>', '<?php echo $message; ?>');" value="<?php echo JText::_('ESHOP_ADD_TO_CART'); ?>" />
										<?php endif;  ?>
										<?php if (EshopHelper::isQuoteMode($product)) : ?>
											<input id="add-to-quote-<?php echo $product->id; ?>" type="button" class="btn btn-primary" onclick="addToQuote(<?php echo $product->id; ?>, 1, '<?php echo EshopHelper::getSiteUrl(); ?>', '<?php echo EshopHelper::getAttachedLangLink(); ?>');" value="<?php echo JText::_('ESHOP_ADD_TO_QUOTE'); ?>" />
										<?php endif; ?>
									</div>
								<?php endif; ?>
							<?php else: ?>
								<div class="eshop-cart-area">
									<a class="<?php echo $btnClass; ?> btn-primary" href="<?php echo $productUrl; ?>" title="<?php echo $product->product_name; ?>"><?php echo JText::_('ESHOP_PRODUCT_VIEW_DETAILS'); ?></a>
								</div>
							<?php endif; ?>

							<div class="eshop-action-btn">
							<?php if (($product->product_quantity <= 0 && EshopHelper::getConfigValue('allow_notify') && !EshopHelper::getConfigValue('stock_checkout')) || EshopHelper::getConfigValue('allow_wishlist') || EshopHelper::getConfigValue('allow_compare')) : ?>
								<?php if ($product->product_quantity <= 0 && EshopHelper::getConfigValue('allow_notify')  && !EshopHelper::getConfigValue('stock_checkout')) : ?>
									<a class="btn btn-outline-secondary btn-sm button" title="<?php echo JText::_('ESHOP_PRODUCT_NOTIFY');?>" onclick="makeNotify(<?php echo $product->id; ?>, '<?php echo EshopHelper::getSiteUrl();?>', '<?php echo EshopHelper::getAttachedLangLink(); ?>')" >
										<i class="fas fa-bell"></i>
										<span><?php echo JText::_('ESHOP_PRODUCT_NOTIFY');?></span>
									</a>
								<?php endif; ?>
								<?php if (EshopHelper::getConfigValue('allow_wishlist')) : ?>
									<a class="btn btn-outline-secondary btn-sm button" title="<?php echo JText::_('ESHOP_ADD_TO_WISH_LIST'); ?>" style="cursor: pointer;" onclick="addToWishList(<?php echo $product->id; ?>, '<?php echo EshopHelper::getSiteUrl(); ?>', '<?php echo EshopHelper::getAttachedLangLink(); ?>')" title="<?php echo JText::_('ESHOP_ADD_TO_WISH_LIST'); ?>">
										<i class="fas fa-heart"></i>
										<span><?php echo JText::_('ESHOP_ADD_TO_WISH_LIST'); ?></span>
									</a>
								<?php endif; ?>
								<?php if (EshopHelper::getConfigValue('allow_compare')) : ?>
									<a class="btn btn-outline-secondary btn-sm button" title="<?php echo JText::_('ESHOP_ADD_TO_COMPARE'); ?>" style="cursor: pointer;" onclick="addToCompare(<?php echo $product->id; ?>, '<?php echo EshopHelper::getSiteUrl(); ?>', '<?php echo EshopHelper::getAttachedLangLink(); ?>')" title="<?php echo JText::_('ESHOP_ADD_TO_COMPARE'); ?>">
										<i class="fas fa-copy"></i>
										<span><?php echo JText::_('ESHOP_ADD_TO_COMPARE'); ?></span>
									</a>
								<?php endif; ?>
							<?php endif; ?>
								<a href="<?php echo $productUrl; ?>" class="btn btn-outline-primary btn-sm" title="<?php echo $product->product_name; ?>">
									<i class="fas fa-info-circle"></i>
									<span>Dettagli</span>
								</a>
							</div>
						</div>
					</div>
				<?php $count++; ?>
				<?php if ($count % $productsPerRow == 0 && $count < count($products)) : ?>
					</div><div class="<?php echo $rowFluidClass; ?> clearfix">
				<?php endif; ?>
			<?php endforeach; ?>
		</div>

		<?php if (EshopHelper::getConfigValue('show_quantity_box') && EshopHelper::getConfigValue('one_add_to_cart_button', '0')) : ?>
			<div class="<?php echo $rowFluidClass; ?>">
				<input id="multiple-products-add-to-cart" type="button" class="<?php echo $btnClass; ?> btn-primary" onclick="multipleProductsAddToCart('<?php echo EshopHelper::getSiteUrl(); ?>', '<?php echo EshopHelper::getAttachedLangLink(); ?>', '<?php echo EshopHelper::getConfigValue('cart_popout')?>', '<?php echo JRoute::_(EshopRoute::getViewRoute('cart')); ?>');" value="<?php echo JText::_('ESHOP_MULTIPLE_PRODUCTS_ADD_TO_CART'); ?>" />
			</div>
		<?php endif; ?>

		<?php if (isset($pagination) && ($pagination->total > $pagination->limit)) : ?>
			<div class="<?php echo $rowFluidClass; ?>">
				<div class="pagination">
					<?php echo $pagination->getPagesLinks(); ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>
