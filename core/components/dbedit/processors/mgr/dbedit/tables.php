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
/* build query */
//$c = $modx->newQuery('Dbedit');
//
//if(!empty($query))
//{
//    $c->where(array(
//        'name:LIKE' => '%'.$query.'%'
//        ,'OR:description:LIKE' => '%'.$query.'%'
//    ));
//}
//
//$count = $modx->getCount('Doodle',$c);
//$c->sortby($sort,$dir);
//if ($isLimit) $c->limit($limit,$start);
//$doodles = $modx->getIterator('Doodle', $c);
 
/* iterate */
$list = array();
foreach ($tables as $table) {
    $tableArray = array();
    $tableArray['name'] = $table;
    $tableArray['status'] = false;
   
    $list[]= $tableArray;
}
return $this->outputArray($list);
?>
