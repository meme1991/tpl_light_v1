<?php
/**
 * @package        Joomla
 * @subpackage     OSMembership
 * @author         Tuan Pham Ngoc
 * @copyright      Copyright (C) 2012 - 2020 Ossolution Team
 * @license        GNU/GPL, see LICENSE.php
 */

defined('_JEXEC') or die;

$bootstrapHelper = OSMembershipHelperBootstrap::getInstance();
?>
<div id="osm-subscription-history" class="wrapper container osm-container">
    <div class="page-title">
      <h1 class="osm-page-title"><?php echo JText::_('OSM_SUBSCRIPTION_HISTORY') ; ?></h1>
    </div>
    <form method="post" name="adminForm" id="adminForm" action="<?php echo JRoute::_('index.php?option=com_osmembership&view=subscriptions&Itemid='.$this->Itemid); ?>">
      <?php
        $layoutData = array(
            'showPagination' => true,
            'pagination'     => $this->pagination
        );
        echo $this->loadCommonLayout('common/tmpl/subscriptions_history.php', $layoutData);
      ?>
    </form>
</div>
