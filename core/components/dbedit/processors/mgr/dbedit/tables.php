<?php
$isLimit = !empty($scriptProperties['limit']);
$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,10);
$sort = $modx->getOption('sort',$scriptProperties,'name');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');
$query = $modx->getOption('query', $scriptProperties, '');
 
$prefix = $modx->getOption('dbedit.prefix');

$results = $modx->query("SHOW TABLES LIKE '".$prefix."%'");
$tables = $results->fetchAll(PDO::FETCH_COLUMN);

$list = array();
foreach ($tables as $table) {
    $tableArray = array();
    
    $colResults = $modx->query("SHOW COLUMNS FROM " . $table);
    $arrColumns = $colResults->fetchAll();
    
    $tableArray['name'] = $table;
    $tableArray['status'] = false;
    $tableArray['columns'] = $arrColumns;
   
    $list[]= $tableArray;
}
return $this->outputArray($list);
?>
