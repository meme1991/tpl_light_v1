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
$controlGroupClass      = $bootstrapHelper->getClassMapping('control-group');
$controlLabelClass      = $bootstrapHelper->getClassMapping('control-label');
$controlsClass          = $bootstrapHelper->getClassMapping('controls');
$pullRightClass         = $bootstrapHelper->getClassMapping('pull-right');
$btnClass				= $bootstrapHelper->getClassMapping('btn');

if (isset($this->success))
{
	?>
	<div class="success"><?php echo $this->success; ?></div>
	<?php
}
?>
<div class="cart-info">
	<table class="table table-responsive table-bordered table-striped">
		<thead>
			<tr>
				<th><?php echo JText::_('ESHOP_PRODUCT_NAME'); ?></th>
				<th><?php echo JText::_('ESHOP_MODEL'); ?></th>
				<th><?php echo JText::_('ESHOP_QUANTITY'); ?></th>
				<th><?php echo JText::_('ESHOP_UNIT_PRICE'); ?></th>
				<th><?php echo JText::_('ESHOP_TOTAL'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($this->cartData as $key => $product)
			{
				$optionData = $product['option_data'];
				$viewProductUrl = JRoute::_(EshopRoute::getProductRoute($product['product_id'], EshopHelper::getProductCategory($product['product_id'])));
				?>
				<tr>
					<td data-content="<?php echo JText::_('ESHOP_PRODUCT_NAME'); ?>">
						<a href="<?php echo $viewProductUrl; ?>">
							<?php echo $product['product_name']; ?>
						</a><br />
						<?php
						for ($i = 0; $n = count($optionData), $i < $n; $i++)
						{
							echo '- ' . $optionData[$i]['option_name'] . ': ' . $optionData[$i]['option_value'] . (isset($optionData[$i]['sku']) && $optionData[$i]['sku'] != '' ? ' (' . $optionData[$i]['sku'] . ')' : '') . '<br />';
						}
						?>
					</td>
					<td data-content="<?php echo JText::_('ESHOP_MODEL'); ?>"><?php echo $product['product_sku']; ?></td>
					<td data-content="<?php echo JText::_('ESHOP_QUANTITY'); ?>">
						<?php echo $product['quantity']; ?>
					</td>
					<td data-content="<?php echo JText::_('ESHOP_UNIT_PRICE'); ?>">
						<?php
						if (EshopHelper::getConfigValue('include_tax_anywhere', '0'))
						{
							echo $this->currency->format($this->tax->calculate($product['price'], $product['product_taxclass_id'], EshopHelper::getConfigValue('tax')));
						}
						else
						{
							echo $this->currency->format($product['price']);
						}
						?>
					</td>
					<td data-content="<?php echo JText::_('ESHOP_TOTAL'); ?>">
						<?php
						if (EshopHelper::showPrice())
						{
							if (EshopHelper::getConfigValue('include_tax_anywhere', '0'))
							{
								echo $this->currency->format($this->tax->calculate($product['total_price'], $product['product_taxclass_id'], EshopHelper::getConfigValue('tax')));
							}
							else
							{
								echo $this->currency->format($product['total_price']);
							}
						}
						?>
					</td>
				</tr>
				<?php
			}
			foreach ($this->totalData as $data)
			{
				?>
				<tr>
					<td colspan="4" style="text-align: right;"><?php echo $data['title']; ?>:</td>
					<td><strong><?php echo $data['text']; ?></strong></td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>
</div>
<?php
if ($this->total > 0)
{

	if ($this->paymentClass->getName() != 'os_squareup')
	{
		?>
		<div class="eshop-payment-information">
			<?php echo $this->paymentClass->renderPaymentInformation($this->privacyPolicyArticleLink, $this->checkoutTermsLink); ?>
		</div>
		<?php
	}
}
else
{
	?>
	<script type="text/javascript">
		function validateCheckoutData()
		{
        	form = document.getElementById('payment_method_form');
            <?php
            if (EshopHelper::getConfigValue('display_privacy_policy', 'payment_method_step') == 'confirm_step')
            {
                if (EshopHelper::getConfigValue('show_privacy_policy_checkbox'))
                {
                    ?>
                    if (!form.privacy_policy_agree.checked)
                    {
                        alert("<?php echo JText::_('ESHOP_AGREE_PRIVACY_POLICY_ERROR'); ?>");
                        form.privacy_policy_agree.focus();
                        return false;
        			}
                    <?php
                }

                if (EshopHelper::getConfigValue('checkout_terms'))
                {
                    ?>
                    if (!form.checkout_terms_agree.checked)
                    {
                        alert("<?php echo JText::_('ESHOP_ERROR_CHECKOUT_TERMS_AGREE'); ?>");
                        form.checkout_terms_agree.focus();
                        return false;
        			}
                    <?php
                }
            }
            ?>
            form.submit();
		}
	</script>
	<form action="<?php echo EshopHelper::getSiteUrl(); ?>index.php?option=com_eshop&task=checkout.processOrder&Itemid=<?php echo EshopRoute::getDefaultItemId(); ?>" method="post" name="payment_method_form" id="payment_method_form" class="form form-horizontal">
		<?php
        if (EshopHelper::getConfigValue('display_privacy_policy', 'payment_method_step') == 'confirm_step')
        {
            if (EshopHelper::getConfigValue('show_privacy_policy_checkbox'))
            {
                ?>
                <div class="<?php echo $controlGroupClass; ?> eshop-privacy-policy">
                	<div class="<?php echo $controlLabelClass; ?>">
                    	<?php
                    	if (isset($this->privacyPolicyArticleLink) && $this->privacyPolicyArticleLink != '')
                    	{
                    	    ?>
                    	    <a class="colorbox cboxElement" href="<?php echo $this->privacyPolicyArticleLink; ?>"><?php echo JText::_('ESHOP_PRIVACY_POLICY'); ?></a>
                    	    <?php
                    	}
                    	else
                    	{
                    	    echo JText::_('ESHOP_PRIVACY_POLICY');
                    	}
                    	?>
                	</div>
                	<div class="<?php echo $controlsClass; ?>">
                		<input type="checkbox" name="privacy_policy_agree" value="1" />
            			<?php
            			$agreePrivacyPolicyMessage = JText::_('ESHOP_AGREE_PRIVACY_POLICY_MESSAGE');

            			if (strlen($agreePrivacyPolicyMessage))
            			{
            			?>
                            <div class="eshop-agree-privacy-policy-message alert alert-info"><?php echo $agreePrivacyPolicyMessage;?></div>
            			<?php
            			}
            			?>
                	</div>
                </div>
                <?php
            }

            if (EshopHelper::getConfigValue('acymailing_integration') || EshopHelper::getConfigValue('mailchimp_integration'))
            {
                ?>
                <div class="<?php echo $controlGroupClass; ?> eshop-newsletter-interest">
                	<label for="textarea" class="checkbox">
                		<input type="checkbox" value="1" name="newsletter_interest" /><?php echo JText::_('ESHOP_NEWSLETTER_INTEREST'); ?>
                	</label>
                </div>
                <?php
            }

            if (isset($this->checkoutTermsLink) && $this->checkoutTermsLink != '')
            {
                ?>
                <div class="<?php echo $controlGroupClass; ?> eshop-checkout-terms">
                	<label for="textarea" class="checkbox">
                		<input type="checkbox" value="1" name="checkout_terms_agree" <?php echo ($this->checkout_terms_agree) ? $this->checkout_terms_agree : ''; ?>/>
            			<?php echo JText::_('ESHOP_CHECKOUT_TERMS_AGREE'); ?>&nbsp;<a class="colorbox cboxElement" href="<?php echo $this->checkoutTermsLink; ?>"><?php echo JText::_('ESHOP_CHECKOUT_TERMS_AGREE_TITLE'); ?></a>
                	</label>
                </div>
                <?php
            }
        }
        ?>
		<div class="no_margin_left">
			<div class="no_margin_left">
				<input id="button-confirm" type="button" onclick="validateCheckoutData();" class="btn btn-primary <?php echo $pullRightClass; ?>" value="<?php echo JText::_('ESHOP_CONFIRM_ORDER'); ?>" />
			</div>
		</div>
		<?php echo JHtml::_('form.token'); ?>
	</form>
	<?php
}
