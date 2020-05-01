<?php
/**
 * @package        	Joomla
 * @subpackage		Event Booking
 * @author  		Tuan Pham Ngoc
 * @copyright    	Copyright (C) 2010 - 2020 Ossolution Team
 * @license        	GNU/GPL, see LICENSE.php
 */

defined( '_JEXEC' ) or die ;

JHtml::_('calendar', '', 'id', 'name');
JHtml::_('bootstrap.tooltip');

EventbookingHelperJquery::validateForm();

if ($this->config->accept_term ==1 && !$this->config->fix_term_and_condition_popup)
{
	EventbookingHelperJquery::colorbox();
}

if ($this->waitingList)
{
	$headerText = JText::_('EB_JOIN_WAITINGLIST');

	if (strlen(strip_tags($this->message->{'waitinglist_form_message' . $this->fieldSuffix})))
	{
		$msg = $this->message->{'waitinglist_form_message' . $this->fieldSuffix};
	}
	else
	{
		$msg = $this->message->waitinglist_form_message;
	}
}
else
{
	$headerText = JText::_('EB_GROUP_REGISTRATION');

	if ($this->fieldSuffix && strlen(strip_tags($this->event->{'registration_form_message_group' . $this->fieldSuffix})))
	{
		$msg = $this->event->{'registration_form_message_group' . $this->fieldSuffix};
	}
	elseif ($this->fieldSuffix && strlen(strip_tags($this->message->{'registration_form_message_group' . $this->fieldSuffix})))
	{
		$msg = $this->message->{'registration_form_message_group' . $this->fieldSuffix};
	}
	elseif (strlen(strip_tags($this->event->registration_form_message_group)))
	{
		$msg = $this->event->registration_form_message_group;
	}
	else
	{
		$msg = $this->message->registration_form_message_group;
	}
}

$replaces = EventbookingHelperRegistration::buildEventTags($this->event, $this->config);

foreach ($replaces as $key => $value)
{
    $key        = strtoupper($key);
    $msg        = str_replace("[$key]", $value, $msg);
    $headerText = str_replace("[$key]", $value, $headerText);
}
?>
<div id="eb-group-registration-form" class="wrapper container eb-container<?php echo $this->waitingList ? ' eb-waitinglist-group-registration-form' : '';?>">
	<h1 class="eb-page-title"><?php echo $headerText; ?></h1>
	<?php
	if (strlen($msg))
	{
	?>
		<div class="eb-message"><?php echo JHtml::_('content.prepare', $msg); ; ?></div>
	<?php
	}

	if (!$this->bypassNumberMembersStep)
	{
	?>
		<div id="eb-number-group-members">
			<div class="eb-form-heading">
				<?php echo JText::_('EB_NUMBER_MEMBERS'); ?>
			</div>
			<div class="eb-form-content">

			</div>
		</div>
	<?php
	}

	if ($this->collectMemberInformation)
	{
	?>
		<div id="eb-group-members-information">
			<div class="eb-form-heading">
				<?php echo JText::_('EB_MEMBERS_INFORMATION'); ?>
			</div>
			<div class="eb-form-content"></div>
		</div>
	<?php
	}

	if($this->showBillingStep)
	{
	?>
		<div id="eb-group-billing">
			<div class="eb-form-heading">
				<?php echo JText::_('EB_BILLING_INFORMATION'); ?>
			</div>
			<div class="eb-form-content"></div>
		</div>
	<?php
	}

	JFactory::getDocument()->addScriptOptions('defaultStep', $this->defaultStep)
		->addScriptOptions('returnUrl', base64_encode(JUri::getInstance()->toString() . '#group_billing'))
		->addScriptOptions('eventId', $this->event->id)
		->addScriptOptions('Itemid', $this->Itemid)
		->addScript(JUri::root(true) . '/media/com_eventbooking/js/site-register-group.min.js')
        ->addScriptDeclaration('var returnUrl = "'.base64_encode(JUri::getInstance()->toString().'#group_billing').'";');
	?>
</div>
