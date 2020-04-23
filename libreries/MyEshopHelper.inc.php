<?php
# @Author: SPEDI srl
# @Date:   27-12-2017
# @Email:  sviluppo@spedi.it
# @Last modified by:   SPEDI srl
# @Last modified time: 24-01-2018
# @License: GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
# @Copyright: Copyright (c) SPEDI srl

/**
  * Ordinare un array multidimensionale per un campo stabilito
  * @param $array multidimensionale da ordinale
  * @param $key chiave del campo da prendere in considerazione per l'ordinamento
  * @return array multidimensionale ordinato
  */
function getCategoryName($product_id){

    // Get a db connection.
    $db = JFactory::getDbo();

    // Create a new query object.
    $query = $db->getQuery(true);

    $query
      ->select(array('c.category_name', 'c.category_id'))
      ->from($db->quoteName('#__eshop_categorydetails', 'c'))
      ->join('LEFT', $db->quoteName('#__eshop_productcategories', 'pc') . ' ON ' . $db->quoteName('c.category_id') . ' = ' . $db->quoteName('pc.category_id'))
      ->where($db->quoteName('pc.product_id') . ' = ' . $db->quote($product_id));

      $db->setQuery($query);

      $row = $db->loadObject();

      return $row;

}


function getProductAttributes($product_id, $attr_list = NULL){

    // Get a db connection.
    $db = JFactory::getDbo();

    // Create a new query object.
    $query = $db->getQuery(true);

    $query
      ->select(array('ad.attribute_name', 'pad.value'))
      ->from($db->quoteName('#__eshop_productattributes', 'pa'))
      ->join('INNER', $db->quoteName('#__eshop_attributedetails', 'ad') . ' ON ' . $db->quoteName('pa.attribute_id') . ' = ' . $db->quoteName('ad.attribute_id'))
      ->join('RIGHT', $db->quoteName('#__eshop_productattributedetails', 'pad') . ' ON ' . $db->quoteName('pa.id') . ' = ' . $db->quoteName('pad.productattribute_id'))
      ->where($db->quoteName('pa.product_id') . ' = ' . $db->quote($product_id));

      $db->setQuery($query);

      $row = $db->loadObjectList();

      $n = count($row);
      if($attr_list != NULL){
        for ($i=0; $i < $n ; $i++) {
          if(!in_array($row[$i]->attribute_name, $attr_list))
            unset($row[$i]);
        }
      }

      $row = array_values($row);

      return $row;
}


function getProductRelated($product){

    // Get a db connection.
    $db = JFactory::getDbo();

    // Create a new query object.
    $query = $db->getQuery(true);

    $name = $product->product_name;

    $query
      ->select(array('pd.product_id', 'p.product_sku', 'pd.product_name', 'p.product_price'))
      ->from($db->quoteName('#__eshop_productdetails', 'pd'))
      ->join('INNER', $db->quoteName('#__eshop_products', 'p') . ' ON ' . $db->quoteName('p.id') . ' = ' . $db->quoteName('pd.product_id'))
      // ->join('RIGHT', $db->quoteName('#__eshop_productattributedetails', 'pad') . ' ON ' . $db->quoteName('pa.id') . ' = ' . $db->quoteName('pad.productattribute_id'))
      ->where($db->quoteName('pd.product_name') . ' = ' . $db->quote($name));

      $db->setQuery($query);

      $row = $db->loadObjectList();

      for ($i=0; $i < count($row) ; $i++) {
        $a = getProductAttributes($row[$i]->product_id, array('Prezzo forbice', 'Utilizzo marca', 'Descrizione'));
        $row[$i]->attribute_list = $a;
      }
      // var_dump($row);

      return $row;
}


function getAttributeValue($attr_list, $attr_name){
  // var_dump($attr_list);

    foreach ($attr_list as $attr) {
      // var_dump($attr);
      if($attr->attribute_name == $attr_name)
        return $attr->value;
    }
    return "-";
}





?>
