<?php
/**
 * @package        Joomla
 * @subpackage     Membership Pro
 * @author         Tuan Pham Ngoc
 * @copyright      Copyright (C) 2012 - 2020 Ossolution Team
 * @license        GNU/GPL, see LICENSE.php
 */

defined('_JEXEC') or die;

/**
 * Layout variables
 *
 * @var OSMembershipHelperBootstrap $bootstrapHelper
 * @var array                       $items
 * @var stdClass                    $config
 * @var int                         $Itemid
 */

$subscribedPlanIds = OSMembershipHelperSubscription::getSubscribedPlans();

if (empty($params))
{
	$params = JFactory::getApplication()->getParams();
}

if (isset($input) && $input->getInt('recommended_plan_id'))
{
	$recommendedPlanId = $input->getInt('recommended_plan_id');
}
else
{
	$recommendedPlanId = (int) $params->get('recommended_campaign_id');
}

$showDetailsButton              = $params->get('show_details_button', 0);

if (isset($input) && $input->getInt('number_columns'))
{
    $numberColumns = $input->getInt('number_columns');
}
elseif (isset($config->number_columns))
{
	$numberColumns = $config->number_columns ;
}
else
{
	$numberColumns = 3 ;
}

$numberColumns = min($numberColumns, 4);

if (!isset($categoryId))
{
	$categoryId = 0;
}

$span = intval(12 / $numberColumns);

$btnClass        = $bootstrapHelper->getClassMapping('btn');
$btnPrimaryClass = $bootstrapHelper->getClassMapping('btn btn-primary');
$imgClass        = $bootstrapHelper->getClassMapping('img-polaroid');
$spanClass       = $bootstrapHelper->getClassMapping('span' . $span);


$rootUri       = JUri::root(true);
$i             = 0;
$numberPlans   = count($items);
// $bootstrapCol  = 12/$numberPlans;
$defaultItemId = $Itemid;

foreach ($items as $item)
{
	$Itemid = OSMembershipHelperRoute::getPlanMenuId($item->id, $item->category_id, $defaultItemId);

	if ($item->thumb)
	{
		$imgSrc = $rootUri . '/media/com_osmembership/' . $item->thumb;
	}

	$url = JRoute::_('index.php?option=com_osmembership&view=plan&catid=' . $item->category_id . '&id=' . $item->id . '&Itemid=' . $Itemid);

	if ($config->use_https)
	{
		$signUpUrl = JRoute::_(OSMembershipHelperRoute::getSignupRoute($item->id, $Itemid), false, 1);
	}
	else
	{
		$signUpUrl = JRoute::_(OSMembershipHelperRoute::getSignupRoute($item->id, $Itemid));
	}

	if (!$item->short_description)
	{
		$item->short_description = $item->description;
	}

	if ($item->id == $recommendedPlanId)
	{
		$recommended = true;
	}
	else
	{
		$recommended = false;
	}

	if ($i % $numberColumns == 0)
	{
	?>
		<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid clearfix'); ?> osm-pricing-table">
	<?php
	}
	?>
	<div class="col-12 <?= $spanClass ?>">
		<div class="card osm-plan<?php if ($recommended) echo ' osm-plan-recommended'; ?> osm-plan-<?php echo $item->id; ?>">
			<?php
				if ($recommended)
				{
				?>
					<p class="plan-recommended"><?php echo JText::_('OSM_RECOMMENDED'); ?></p>
				<?php
				}
			?>
			<div class="osm-plan-header card-header">
				<h2 class="osm-plan-title">
					<?php echo $item->title; ?>
				</h2>
			</div>
			<div class="card-body">
				<div class="osm-plan-price">
					<?php
						switch ($item->subscription_length_unit) {
							case 'D': $subscription_length_unit = 'Giorni'; break;
							case 'W': $subscription_length_unit = 'Sett.'; break;
							case 'M': $subscription_length_unit = 'Mesi'; break;
							case 'Y': $subscription_length_unit = 'Anni'; break;
							default: $subscription_length_unit = 'Giorni'; break;
						}
					?>
					<h2>
						<?php if ($item->price > 0) : ?>
							<?php $symbol = $item->currency_symbol ? $item->currency_symbol : $item->currency; ?>
							<?php echo str_replace('.01', '.00', OSMembershipHelper::formatCurrency($item->price, $config, $symbol)); ?>
						<?php else : ?>
							<?php echo JText::_('OSM_FREE'); ?>
						<?php endif; ?>
						<small>/
							<?= $item->subscription_length ?>
							<?= $subscription_length_unit ?>
						</small>
					</h2>
					<?php
					  // subscription_length INT
						// subscription_length_unit D W M Y
						// trial_duration INT
						// trial_duration_unit D W M Y
					  ?>
				</div>
				<div class="osm-plan-short-description">
					<?php echo $item->short_description;?>
				</div>

				<?php $actions = OSMembershipHelperSubscription::getAllowedActions($item); ?>

	      <?php if (count($actions)) : ?>
					 <ul class="osm-signup-container">
	           <?php if (in_array('subscribe', $actions)) : ?>
	             <li>
	               <a href="<?php echo $signUpUrl; ?>" class="btn btn-primary btn-block btn-singup">
			             <?php echo in_array($item->id, $subscribedPlanIds) ? JText::_('OSM_RENEW') : JText::_('OSM_SIGNUP'); ?>
	               </a>
	             </li>
	           <?php endif; ?>

	           <?php if (in_array('upgrade', $actions)) : ?>
	             <?php if (count($item->upgrade_rules) > 1) : ?>
	               <?php $link = JRoute::_('index.php?option=com_osmembership&view=upgrademembership&to_plan_id=' . $item->id . '&Itemid=' . OSMembershipHelperRoute::findView('upgrademembership', $Itemid)); ?>
							 <?php else : ?>
	               <?php $upgradeOptionId = $item->upgrade_rules[0]->id; ?>
	               <?php $link = JRoute::_('index.php?option=com_osmembership&task=register.process_upgrade_membership&upgrade_option_id=' . $upgradeOptionId . '&Itemid=' . $Itemid); ?>
	             <?php endif; ?>
	             <li>
	               <a href="<?php echo $link; ?>" class="<?php echo $btnPrimaryClass; ?> btn-singup">
		               <?php echo JText::_('OSM_UPGRADE'); ?>
	               </a>
	             </li>
	           <?php endif; ?>

						 <?php if ($showDetailsButton) : ?>
							<li>
								<a href="<?php echo $url; ?>" class="btn btn-outline-primary btn-block">
									<?php echo JText::_('OSM_DETAILS'); ?>
								</a>
							</li>
	            <?php endif; ?>
					</ul>
				<?php endif; ?>

			</div>
		</div>
	</div>
<?php
	if (($i + 1) % $numberColumns == 0)
	{
	?>
		</div>
	<?php
	}
	$i++;
}

if ($i % $numberColumns != 0)
{
	echo "</div>" ;
}
