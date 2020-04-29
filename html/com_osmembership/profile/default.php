<?php
/**
 * @package        Joomla
 * @subpackage     Membership Pro
 * @author         Tuan Pham Ngoc
 * @copyright      Copyright (C) 2012 - 2020 Ossolution Team
 * @license        GNU/GPL, see LICENSE.php
 */

defined( '_JEXEC' ) or die ;

JHtml::_('behavior.core');

OSMembershipHelperJquery::validateForm();

$document = JFactory::getDocument();
$document->addScriptDeclaration('var siteUrl = "' . OSMembershipHelper::getSiteUrl() . '";');
$document->addScript(JUri::root(true) . '/media/com_osmembership/js/site-profile-default.min.js');
JText::script('OSM_CANCEL_SUBSCRIPTION_CONFIRM', true);


if ($this->config->use_https)
{
	$ssl = 1;
}
else
{
	$ssl = 0;
}

$fields = $this->form->getFields();

if (isset($fields['state']))
{
	$selectedState = $fields['state']->value;
}
else
{
	$selectedState = '';
}

$document->addScriptOptions('selectedState', $selectedState);


/* @var OSMembershipHelperBootstrap $bootstrapHelper*/
$bootstrapHelper = $this->bootstrapHelper;

// Get mapping classes, make them ready for using
$rowFluidClass     = $bootstrapHelper->getClassMapping('row-fluid');
$controlGroupClass = $bootstrapHelper->getClassMapping('control-group');
$inputPrependClass = $bootstrapHelper->getClassMapping('input-group');
$addOnClass        = $bootstrapHelper->getClassMapping('add-on');
$controlLabelClass = $bootstrapHelper->getClassMapping('control-label');
$controlsClass     = $bootstrapHelper->getClassMapping('controls');
$btnClass          = $bootstrapHelper->getClassMapping('btn');

$fieldSuffix = OSMembershipHelper::getFieldSuffix();
?>
<div id="osm-profile-page" class="wrapper container osm-container">
	<div class="title-page">
		<h1 class="osm-page-title"><?php echo JText::_('OSM_USER_PROFILE'); ?></h1>
	</div>
	<form action="<?php echo JRoute::_('index.php?option=com_osmembership&Itemid='.$this->Itemid) ?>" method="post" name="osm_form" id="osm_form" autocomplete="off" enctype="multipart/form-data" class="<?php echo $bootstrapHelper->getClassMapping('form form-horizontal'); ?>">
		<?php
	    $pluginExists = false;

	    foreach ($this->plugins as $plugin)
	    {
	        if (!empty($plugin['form']))
	        {
	            $pluginExists = true;
	            break;
	        }
	    }

		$showTabs = $this->params->get('show_edit_profile', 1)
			|| $this->params->get('show_my_subscriptions', 1)
			|| $this->params->get('show_subscriptions_history', 1)
			|| $pluginExists;

	    if ($this->params->get('show_edit_profile', 1))
	    {
	        $activeTab = 'profile-page';
	    }
	    elseif ($this->params->get('show_my_subscriptions', 1))
	    {
	        $activeTab = 'my-subscriptions-page';
	    }
	    else
	    {
	        $activeTab = 'subscription-history-page';
	    }

		if ($showTabs)
	    {
		    echo JHtml::_('bootstrap.startTabSet', 'osm-profile', array('active' => $activeTab));
	    }

	    if ($this->params->get('show_edit_profile', 1))
	    {
	        if ($showTabs)
	        {
		        echo JHtml::_('bootstrap.addTab', 'osm-profile', 'profile-page', JText::_('OSM_EDIT_PROFILE', true));
	        }

		    $profileLayoutData = array(
			    'controlGroupClass' => $controlGroupClass,
			    'controlLabelClass' => $controlLabelClass,
			    'controlsClass' => $controlsClass,
			    'bootstrapHelper' => $bootstrapHelper,
			    'btnClass' => $btnClass
		    );

		    echo $this->loadTemplate('profile', $profileLayoutData);

		    if ($showTabs)
		    {
			    echo JHtml::_('bootstrap.endTab');
		    }
	    }

	    if ($this->params->get('show_my_subscriptions', 1))
	    {
	        if ($showTabs)
	        {
		        echo JHtml::_('bootstrap.addTab', 'osm-profile', 'my-subscriptions-page', JText::_('OSM_MY_SUBSCRIPTIONS', true));
	        }

		    echo $this->loadTemplate('subscriptions');

	        if ($showTabs)
	        {
		        echo JHtml::_('bootstrap.endTab');
	        }
	    }

		if ($this->params->get('show_subscriptions_history', 1))
	    {
	        if ($showTabs)
	        {
		        echo JHtml::_('bootstrap.addTab', 'osm-profile', 'subscription-history-page', JText::_('OSM_SUBSCRIPTION_HISTORY', true));
	        }

		    $layoutData = array(
			    'showPagination' => false,
		    );
		    echo $this->loadCommonLayout('common/tmpl/subscriptions_history.php', $layoutData);

		    if ($showTabs)
	        {
		        echo JHtml::_('bootstrap.endTab');
	        }
	    }

		if ($pluginExists)
		{
			$count = 0 ;

			foreach ($this->plugins as $plugin)
			{
				$count++ ;

				if (empty($plugin['form']))
				{
					continue;
				}

				echo JHtml::_('bootstrap.addTab', 'osm-profile', 'tab_'.$count, JText::_($plugin['title'], true));
				echo $plugin['form'];
				echo JHtml::_('bootstrap.endTab');
			}
		}

		if ($showTabs)
	    {
		    echo JHtml::_('bootstrap.endTabSet');
	    }
		?>
		<div class="clearfix"></div>
		<input type="hidden" name="cid[]" value="<?php echo $this->item->id; ?>" />
		<input type="hidden" name="task" value="profile.update" />
		<?php echo JHtml::_( 'form.token' ); ?>
	</form>

	<?php
	// Renew Membership
	if ($this->params->get('show_renew_options', 1) && $this->item->group_admin_id == 0 && count($this->planIds))
	{
	?>
		<form action="<?php echo JRoute::_('index.php?option=com_osmembership&task=register.process_renew_membership&Itemid=' . $this->Itemid, false, $ssl); ?>" method="post" name="osm_form_renew" id="osm_form_renew" autocomplete="off" class="<?php echo $bootstrapHelper->getClassMapping('form form-horizontal'); ?>">
			<h2 class="osm-form-heading"><?php echo JText::_('OSM_RENEW_MEMBERSHIP'); ?></h2>
			<?php echo $this->loadCommonLayout('common/tmpl/renew_options.php');?>
		</form>
	<?php
	}

	// Upgrade Membership
	if ($this->params->get('show_upgrade_options', 1) && $this->item->group_admin_id == 0 && !empty($this->upgradeRules))
	{
	?>
		<form action="<?php echo JRoute::_('index.php?option=com_osmembership&task=register.process_upgrade_membership&Itemid='.$this->Itemid, false, $ssl); ?>" method="post" name="osm_form_update_membership" id="osm_form_update_membership" autocomplete="off" class="<?php echo $bootstrapHelper->getClassMapping('form form-horizontal'); ?>">
			<h2 class="osm-form-heading"><?php echo JText::_('OSM_UPGRADE_MEMBERSHIP'); ?></h2>
			<?php
				echo $this->loadCommonLayout('common/tmpl/upgrade_options.php');
			?>
			<div class="form-actions">
				<input type="submit" class="<?php echo $bootstrapHelper->getClassMapping('btn btn-primary'); ?>" value="<?php echo JText::_('OSM_PROCESS_UPGRADE'); ?>"/>
			</div>
		</form>
	<?php
	}
	?>

	<form action="<?php echo JRoute::_('index.php?option=com_osmembership&task=register.process_cancel_subscription&Itemid='.$this->Itemid, false, $ssl); ?>" method="post" name="osm_form_cancel_subscription" id="osm_form_cancel_subscription" autocomplete="off" class="form form-horizontal">
		<input type="hidden" name="subscription_id" value="" />
		<?php echo JHtml::_( 'form.token' ); ?>
	</form>
</div>
