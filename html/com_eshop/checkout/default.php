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
$rowFuildClass          = $bootstrapHelper->getClassMapping('row-fluid');
$controlGroupClass      = $bootstrapHelper->getClassMapping('control-group');
$controlLabelClass      = $bootstrapHelper->getClassMapping('control-label');
$controlsClass          = $bootstrapHelper->getClassMapping('controls');
$pullRightClass         = $bootstrapHelper->getClassMapping('pull-right');
$btnClass				= $bootstrapHelper->getClassMapping('btn');
?>
<h1>
	<?php echo JText::_('ESHOP_CHECKOUT'); ?>
	<?php
	if ($this->weight)
	{
		echo '&nbsp;(' . $this->weight . ')';
	}
	?>
</h1><br />
<div class="<?php echo $rowFuildClass; ?>">
    <div id="checkout-options">
    	<div class="checkout-heading"><?php echo JText::_('ESHOP_CHECKOUT_STEP_1'); ?></div>
    	<div class="checkout-content"></div>
    </div>
    <div id="payment-address">
    	<div class="checkout-heading">
    		<?php
    		if (EshopHelper::getCheckoutType() == 'guest_only')
    		{
    			echo JText::_('ESHOP_CHECKOUT_STEP_2_GUEST');
    		}
    		else
    		{
    			echo JText::_('ESHOP_CHECKOUT_STEP_2_REGISTER');
    		}
    		?>
    	</div>
    	<div class="checkout-content"></div>
    </div>
    <?php
    if ($this->shipping_required)
    {
    	if (EshopHelper::getConfigValue('require_shipping_address', 1))
    	{
    		?>
    		<div id="shipping-address">
    			<div class="checkout-heading"><?php echo JText::_('ESHOP_CHECKOUT_STEP_3'); ?></div>
    			<div class="checkout-content"></div>
    		</div>
    		<?php
    	}
    	?>
    	<div id="shipping-method">
    		<div class="checkout-heading"><?php echo JText::_('ESHOP_CHECKOUT_STEP_4'); ?></div>
    		<div class="checkout-content form-horizontal"></div>
    	</div>
    	<?php
    }
    ?>
    <div id="payment-method">
    	<div class="checkout-heading"><?php echo JText::_('ESHOP_CHECKOUT_STEP_5'); ?></div>
    	<div class="checkout-content form-horizontal"></div>
    </div>
    <div id="confirm">
    	<div class="checkout-heading"><?php echo JText::_('ESHOP_CHECKOUT_STEP_6'); ?></div>
    	<div class="checkout-content"></div>
    		<?php
    		$paymentMethods = os_payments::getPaymentMethods();
    		foreach ($paymentMethods as $paymentMethod)
    		{

    			$params = $paymentMethod->getParams();
    			$applicationId = $params->get('application_id');
    			if ($paymentMethod->getName() == 'os_squareup')
    			{
    				$currentYear = date('Y');
    				?>
    				<div class="eshop-squareup-information" style="display: none;">
    					<script type="text/javascript">
    			            Eshop.jQuery(document).ready(function($){
    			        		// Confirm button
    			        		$('#squareup-button-confirm').click(function() {
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

    								if ($this->showCaptcha)
    								{
							            if ($this->captchaPlugin == 'recaptcha' || $this->captchaPlugin == 'recaptcha_invisible')
    									{
    										?>
    										var siteUrl = '<?php echo EshopHelper::getSiteUrl(); ?>';
    										jQuery.ajax({
    				            				url: siteUrl + 'index.php?option=com_eshop&task=checkout.validateCaptcha',
    				            				type: 'post',
    				            				dataType: 'json',
    				            				//data: jQuery('#payment_method_form input[type=\'text\'], #payment_method_form input[type=\'radio\']:checked, #payment_method_form input[type=\'hidden\']'),
    											data: jQuery('#payment_method_form').serialize(),
    				            				beforeSend: function() {
    					            				// Do nothing
    				            				},
    				            				complete: function() {
    				            					$('#squareup-button-confirm').attr('disabled', false);
    				            					$('.wait').remove();
    				            				},
    				            				success: function(data) {
    				            					if (data['error']) {
    				            						alert(data['error']);
    				            					}
    				            					if (data['success']) {
    				            						sqPaymentForm.requestCardNonce();
    				            					}
    				            				}
    			            				});
    			            				<?php
    									}
    									else
    									{
    										?>
    		            					sqPaymentForm.requestCardNonce();
    										<?php
    									}
    								}
    								else
    								{
    									?>
    		        					sqPaymentForm.requestCardNonce();
    									<?php
    								}
    			            		?>
    			        		})
    			            })
    			        </script>
    			        <form action="<?php echo EshopHelper::getSiteUrl(); ?>index.php?option=com_eshop&task=checkout.processOrder&Itemid=<?php echo EshopRoute::getDefaultItemId(); ?>" method="post" name="payment_method_form" id="payment_method_form" class="form form-horizontal">
    			            <div class="no_margin_left">
    	                    	<div class="<?php echo $controlGroupClass; ?>">
    	                            <div class="<?php echo $controlLabelClass; ?>">
    	                                <?php echo  JText::_('ESHOP_SQUAREUP_ZIPCODE'); ?><span class="required">*</span>
    	                            </div>
    	                            <div class="<?php echo $controlsClass; ?>" id="field_zip_input"></div>
    	                        </div>
    	                        <div class="<?php echo $controlGroupClass; ?>">
    	                            <div class="<?php echo $controlLabelClass; ?>">
    	                                <?php echo  JText::_('ESHOP_CARD_NUMBER'); ?><span class="required">*</span>
    	                            </div>
    	                            <div class="<?php echo $controlsClass; ?>" id="sq-card-number"></div>
    	                        </div>
    	                        <div class="<?php echo $controlGroupClass; ?>">
    	                            <div class="<?php echo $controlLabelClass; ?>">
    	                                <?php echo  JText::_('ESHOP_CARD_EXPIRY_DATE'); ?><span class="required">*</span>
    	                            </div>
    	                            <div class="<?php echo $controlsClass; ?>" id="sq-expiration-date"></div>
    	                        </div>
    	                        <div class="<?php echo $controlGroupClass; ?>">
    	                            <label class="<?php echo $controlLabelClass; ?>" for="cvv_code">
    	                                <?php echo JText::_('ESHOP_CVV_CODE'); ?><span class="required">*</span>
    	                            </label>
    	                            <div class="<?php echo $controlsClass; ?>" id="sq-cvv"></div>
    	                        </div>
    	                        <?php
                    			if (EshopHelper::getConfigValue('display_privacy_policy', 'payment_method_step') == 'confirm_step')
        	                    {
        	                        if (EshopHelper::getConfigValue('show_privacy_policy_checkbox'))
        	                        {
        	                            $privacyPolicyArticleLink  = EshopHelper::getPrivacyPolicyArticleLink();
        	                            $checkoutTermsLink         = EshopHelper::getCheckoutTermsLink();
        	                            ?>
                                        <div class="<?php echo $controlGroupClass; ?> eshop-privacy-policy">
                                        	<div class="<?php echo $controlLabelClass; ?>">
                                            	<?php
                                            	if ($privacyPolicyArticleLink != '')
                                            	{
                                            	    ?>
                                            	    <a class="colorbox cboxElement" href="<?php echo $privacyPolicyArticleLink; ?>"><?php echo JText::_('ESHOP_PRIVACY_POLICY'); ?></a>
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

                                    if ($checkoutTermsLink != '')
                                    {
                                        ?>
                                        <div class="<?php echo $controlGroupClass; ?> eshop-checkout-terms">
                                        	<label for="textarea" class="checkbox">
                                        		<input type="checkbox" value="1" name="checkout_terms_agree" <?php echo ($this->checkout_terms_agree) ? $this->checkout_terms_agree : ''; ?>/>
                                    			<?php echo JText::_('ESHOP_CHECKOUT_TERMS_AGREE'); ?>&nbsp;<a class="colorbox cboxElement" href="<?php echo $checkoutTermsLink; ?>"><?php echo JText::_('ESHOP_CHECKOUT_TERMS_AGREE_TITLE'); ?></a>
                                        	</label>
                                        </div>
                                        <?php
                                    }
                                }

    	                        if ($this->showCaptcha)
    	                        {
			                        if ($this->captchaPlugin == 'recaptcha' || $this->captchaPlugin == 'recaptcha_invisible')
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
    							}
    	                        ?>
    			                <div class="no_margin_left">
    			                	<input id="squareup-button-confirm" type="button" class="btn btn-primary <?php echo $pullRightClass; ?>" value="<?php echo JText::_('ESHOP_CONFIRM_ORDER'); ?>" />
    			                </div>
    			            </div>
    			            <input type="hidden" id="card-nonce" name="nonce" />
    			            <?php echo JHtml::_('form.token'); ?>
    			        </form>
    				</div>
    				<?php
    			}
    		}
    		?>
    </div>
</div>
<script type="text/javascript">
	Eshop.jQuery(function($){
		//Script to allow Edit step
		$('.checkout-heading').on('click', 'a', function() {
			$('.checkout-content').slideUp('slow');
			if ($('#confirm .eshop-squareup-information').length)
			{
				$('#confirm .eshop-squareup-information').css('display', 'none');
			}
			$(this).parent().parent().find('.checkout-content').slideDown('slow');
		});
		//If user is not logged in, then show login layout
		<?php
		if (!$this->user->get('id'))
		{
			if (EshopHelper::getConfigValue('checkout_type') == 'guest_only')
			{
				?>
				$(document).ready(function() {
					var siteUrl = '<?php echo EshopHelper::getSiteUrl(); ?>';
					$.ajax({
						url: siteUrl + 'index.php?option=com_eshop&view=checkout&layout=guest&format=raw<?php echo EshopHelper::getAttachedLangLink(); ?>',
						dataType: 'html',
						success: function(html) {
							$('#payment-address .checkout-content').html(html);
							$('#payment-address .checkout-content').slideDown('slow');
						},
						error: function(xhr, ajaxOptions, thrownError) {
							alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
						}
					});
				});
				<?php
			}
			else
			{
				?>
				$(document).ready(function() {
					var siteUrl = '<?php echo EshopHelper::getSiteUrl(); ?>';
					$.ajax({
						url: siteUrl + 'index.php?option=com_eshop&view=checkout&layout=login&format=raw<?php echo EshopHelper::getAttachedLangLink(); ?>',
						dataType: 'html',
						success: function(html) {
							$('#checkout-options .checkout-content').html(html);
							$('#checkout-options .checkout-content').slideDown('slow');
						},
						error: function(xhr, ajaxOptions, thrownError) {
							alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
						}
					});
				});
				<?php
			}
		}
		//Else, show payment address layout
		else
		{
			?>
			$('#payment-address .checkout-heading').html('<?php echo JText::_('ESHOP_CHECKOUT_STEP_2_GUEST'); ?>');
			$(document).ready(function() {
				var siteUrl = '<?php echo EshopHelper::getSiteUrl(); ?>';
				$.ajax({
					url: siteUrl + 'index.php?option=com_eshop&view=checkout&layout=payment_address&format=raw<?php echo EshopHelper::getAttachedLangLink(); ?>',
					dataType: 'html',
					success: function(html) {
						$('#payment-address .checkout-content').html(html);
						$('#payment-address .checkout-content').slideDown('slow');
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
			});
			<?php
		}
		?>
	});
</script>
