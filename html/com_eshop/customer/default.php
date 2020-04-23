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
if (isset($this->success))
{
	?>
	<div class="success"><?php echo $this->success; ?></div>
	<?php
}
?>
<section class="eshop-account-default">
	<h1><?php echo JText::_('ESHOP_MY_ACCOUNT'); ?></h1>
	<?php if (EshopHelper::getConfigValue('customer_manage_account', '1') || EshopHelper::getConfigValue('customer_manage_order', '1') || EshopHelper::getConfigValue('customer_manage_download', '1') || EshopHelper::getConfigValue('customer_manage_address', '1')) : ?>
		<div class="container-fluid">
			<div class="row">
				<?php if (EshopHelper::getConfigValue('customer_manage_account', '1')) : ?>
					<div class="col-12 col-md-3 account-box">
						<div class="container-icon d-flex align-items-center justify-content-center">
							<i class="fal fa-user"></i>
						</div>
						<a href="<?php echo JRoute::_(EshopRoute::getViewRoute('customer').'&layout=account'); ?>">
							<h6><?php echo JText::_('ESHOP_EDIT_ACCOUNT'); ?></h6>
						</a>
					</div>
				<?php endif; ?>

				<?php if (EshopHelper::getConfigValue('customer_manage_order', '1')) : ?>
					<div class="col-12 col-md-3 account-box">
						<div class="container-icon d-flex align-items-center justify-content-center">
							<i class="fal fa-list-ol"></i>
						</div>
						<a href="<?php echo JRoute::_(EshopRoute::getViewRoute('customer').'&layout=orders'); ?>">
							<h6><?php echo JText::_('ESHOP_ORDER_HISTORY'); ?></h6>
						</a>
					</div>
				<?php endif; ?>

				<?php if (EshopHelper::getConfigValue('customer_manage_download', '1')) : ?>
					<div class="col-12 col-md-3 account-box">
						<div class="container-icon d-flex align-items-center justify-content-center">
							<i class="fal fa-download"></i>
						</div>
						<a href="<?php echo JRoute::_(EshopRoute::getViewRoute('customer').'&layout=downloads'); ?>">
							<h6><?php echo JText::_('ESHOP_DOWNLOADS'); ?></h6>
						</a>
					</div>
				<?php endif; ?>


				<?php if (EshopHelper::getConfigValue('customer_manage_address', '1')) : ?>
					<div class="col-12 col-md-3 account-box">
						<div class="container-icon d-flex align-items-center justify-content-center">
							<i class="fal fa-map-marker-alt"></i>
						</div>
						<a href="<?php echo JRoute::_(EshopRoute::getViewRoute('customer').'&layout=addresses'); ?>">
							<h6><?php echo JText::_('ESHOP_MODIFY_ADDRESS'); ?></h6>
						</a>
					</div>
				<?php endif; ?>
			</div>
		</div>
	<?php else : ?>
		<?php echo JText::_('ESHOP_CUSTOMER_PAGE_NOT_AVAILABLE'); ?>
	<?php endif; ?>
</section>
