<?php
# @Author: SPEDI srl
# @Date:   27-12-2017
# @Email:  sviluppo@spedi.it
# @Last modified by:   SPEDI srl
# @Last modified time: 24-01-2018
# @License: GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
# @Copyright: Copyright (c) SPEDI srl


define('_JEXEC', 1);
define('JPATH_BASE', '../../../');
require_once JPATH_BASE . 'includes/defines.php';
require_once JPATH_BASE . 'includes/framework.php';
require_once JPATH_BASE.'/components/com_content/helpers/route.php';
require_once JPATH_BASE.'/components/com_eshop/helpers/helper.php';
require_once JPATH_BASE.'/components/com_eshop/helpers/route.php';

// Create the Application
$app = JFactory::getApplication('site');

$lang = JFactory::getLanguage();
$lang->setLanguage('it-IT' );
$lang->setDefault('it-IT');
$lang->load();

// Get a db connection.
$db = JFactory::getDbo();

// Create a new query object.
$query = $db->getQuery(true);

$keyword = $_POST['keyword'];
$query
  ->select(array('cd.category_name', 'cd.category_id'))
  ->from($db->quoteName('#__eshop_categorydetails', 'cd'))
  ->join('LEFT', $db->quoteName('#__eshop_categories', 'c') . ' ON ' . $db->quoteName('c.id') . ' = ' . $db->quoteName('cd.category_id'))
  ->where($db->quoteName('c.category_parent_id').' <> 0 ')
  ->where($db->quoteName('cd.category_name').' LIKE '. $db->quote($db->escape($keyword.'%')));

  $db->setQuery($query);

  $row = $db->loadObjectList();

  if($row){
    foreach ($row as $key => $category) {
      // echo "<li><a href=".JRoute::_(EshopRoute::getCategoryRoute($category->category_id)).">". $category->category_name ."</a></li>";
      echo "<li><a href=".EshopRoute::getCategoryRoute($category->category_id).">". $category->category_name ."</a></li>";
      // var_dump(JRoute::_(EshopRoute::getCategoryRoute($category->category_id)));
    }
  }else{
    echo "<li>Nessun risultato...</li>";
  }
