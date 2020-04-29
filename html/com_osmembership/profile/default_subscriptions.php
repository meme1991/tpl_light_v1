<?php
/**
 * @package        Joomla
 * @subpackage     Membership Pro
 * @author         Tuan Pham Ngoc
 * @copyright      Copyright (C) 2012 - 2020 Ossolution Team
 * @license        GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die;

$centerClass = $this->bootstrapHelper->getClassMapping('center');

$defaultItemId = OSMembershipHelper::getItemid();
?>
<table class="<?php echo $this->bootstrapHelper->getClassMapping('table table-striped table-bordered'); ?>">
	<thead>
	<tr>
		<th>
			<?php echo JText::_('OSM_PLAN') ?>
		</th>
		<th width="20%" class="<?php echo $centerClass; ?>">
			<?php echo JText::_('OSM_ACTIVATE_TIME') ; ?>
		</th>
		<th width="20%" class="<?php echo $centerClass; ?>">
			<?php echo JText::_('OSM_SUBSCRIPTION_STATUS'); ?>
		</th>
		<th width="20%" class="<?php echo $centerClass; ?>">
			<?php echo JText::_('Azioni'); ?>
		</th>
    <?php if ($this->showDownloadMemberCard) : ?>
      <th width="20%" class="<?php echo $centerClass; ?>">
      <?php echo JText::_('OSM_MEMBER_CARD'); ?>
      </th>
	  <?php endif; ?>
	</tr>
	</thead>
	<tbody>
	<?php
	foreach($this->subscriptions as $subscription)
	{
		$Itemid = OSMembershipHelperRoute::getPlanMenuId($subscription->id, $subscription->category_id, $defaultItemId);

		if ($subscription->category_id)
		{
			$url = JRoute::_('index.php?option=com_osmembership&view=plan&catid=' . $subscription->category_id . '&id=' . $subscription->id . '&Itemid=' . $Itemid);
		}
		else
		{
			$url = JRoute::_('index.php?option=com_osmembership&view=plan&id=' . $subscription->id . '&Itemid=' . $Itemid);
		}
	?>
		<tr>
			<td>
				<a href="<?php echo $url ?>" target="_blank"><?php echo $subscription->title; ?></a>
			</td>
			<td class="<?php echo $centerClass; ?>">
				<strong><?php echo JHtml::_('date', $subscription->subscription_from_date, $this->config->date_format, null); ?></strong> <?php echo JText::_('OSM_TO'); ?>
				<strong>
					<?php
					if ($subscription->lifetime_membership || $subscription->subscription_to_date  == '2099-12-31 23:59:59')
					{
						echo JText::_('OSM_LIFETIME');
					}
					else
					{
						echo JHtml::_('date', $subscription->subscription_to_date , $this->config->date_format);
					}
					?>
				</strong>
			</td>
			<td class="<?php echo $centerClass; ?>">
				<?php
				switch ($subscription->subscription_status)
				{
					case 0 :
						echo JText::_('OSM_PENDING');
						break ;
					case 1 :
						echo JText::_('OSM_ACTIVE');
						break ;
					case 2 :
						echo JText::_('OSM_EXPIRED');
						break ;
					default:
						echo JText::_('OSM_CANCELLED');
						break;
				}
			?>
			</td>
			<td class="<?php echo $centerClass; ?>">
				<?php if ($subscription->subscription_status == 1 && $subscription->subscription_id) : ?>
					<a class="btn btn-outline-danger osm-btn-cancel-subscription" href="javascript:cancelSubscription('<?php echo $subscription->subscription_id;  ?>');"><?php echo JText::_('OSM_CANCEL_SUBSCRIPTION'); ?></a>
				<?php endif; ?>

				<?php  if ($subscription->recurring_cancelled) : ?>
					<span class="d-block text-error text-danger"><?= JText::_('OSM_RECURRING_CANCELLED') ?></span>
				<?php elseif($subscription->subscription_id) : ?>
					<?php $subscriptionInfo = OSMembershipHelperSubscription::getSubscription($subscription->subscription_id); ?>
					<?php $method = OSMembershipHelperPayments::getPaymentMethod($subscriptionInfo->payment_method); ?>

					<?php if (method_exists($method, 'updateCard')) : ?>
						<a href="<?php echo JRoute::_('index.php?option=com_osmembership&view=card&subscription_id=' . $subscription->subscription_id . '&Itemid=' . $this->Itemid); ?>" class="btn btn-primary osm-btn-update-card"><?php echo JText::_('OSM_UPDATE_CARD');  ?></a>
					<?php endif; ?>
				<?php endif; ?>
			</td>

      <?php if ($this->showDownloadMemberCard) : ?>
        <td class="center">
          <?php if ($subscription->show_download_member_card) : ?>
            <a class="download-member-card-link" href="<?php echo JText::_('index.php?option=com_osmembership&task=profile.download_member_plan_card&plan_id=' . $subscription->id . '&Itemid=' . $this->Itemid); ?>"><strong><?php echo JText::_('OSM_DOWNLOAD'); ?></strong></a>
          <?php endif; ?>
        </td>
      <?php endif; ?>
		</tr>
	<?php
	}
	?>
	</tbody>
</table>
