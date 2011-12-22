<?php
$isLimit = !empty($scriptProperties['limit']);
$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,10);
$sort = $modx->getOption('sort',$scriptProperties,'id');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');
$query = $modx->getOption('query', $scriptProperties, '');

include dirname(dirname(__FILE__)).'/xpdo.config.php';

$class = 'Relationships';
/* build query */
$c = $xpdo->newQuery($class);

$count = $xpdo->getCount($class,$c);
$c->sortby($sort,$dir);
if ($isLimit) $c->limit($limit,$start);
$records = $xpdo->getIterator($class, $c);
 
/* iterate */
$list = array();
foreach ($records as $record) 
{
    $recordArray = $record->toArray();   
    $list[]= $recordArray;
}
return $this->outputArray($list);
?>
