<?php
$isLimit = !empty($scriptProperties['limit']);
$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,10);
$sort = $modx->getOption('sort',$scriptProperties,'name');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');
$query = $modx->getOption('query', $scriptProperties, '');
$class = $modx->getOption('class', $scriptProperties);

// Include the xpdo object.  We'll need this later
include dirname(dirname(__FILE__)).'/xpdo.config.php';

$arrFieldMeta = $xpdo->getFieldMeta($class);
$arrCols = array();

foreach($arrFieldMeta as $key => $value)
{
    $arrCols[] = array('column' => $key);
}

return $this->outputArray($arrCols);


