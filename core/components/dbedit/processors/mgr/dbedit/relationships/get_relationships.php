<?php
$isLimit = !empty($scriptProperties['limit']);
$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,10);
$sort = $modx->getOption('sort',$scriptProperties,'id');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');

$class = 'Relationships';
/* build query */
$c = $modx->newQuery($class);

$count = $modx->getCount($class,$c);
$c->sortby($sort,$dir);
if ($isLimit) $c->limit($limit,$start);
$records = $modx->getIterator($class, $c);
 
/* iterate */
$list = array();
foreach ($records as $record) 
{
    $recordArray = $record->toArray();   
    $list[]= $recordArray;
}
return $this->outputArray($list,$count);
?>
