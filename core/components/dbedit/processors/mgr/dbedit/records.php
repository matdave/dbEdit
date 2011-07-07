<?php
$isLimit = !empty($scriptProperties['limit']);
$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,10);
$sort = $modx->getOption('sort',$scriptProperties,'id');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');
$query = $modx->getOption('query', $scriptProperties, '');
$class = $modx->getOption('tableClass', $scriptProperties, '');
$table = $modx->getOption('userTable', $scriptProperties, '');

include 'xpdo.config.php';

/* build query */
$c = $xpdo->newQuery($class);

//if(!empty($query))
//{
//    $c->where(array(
//        'name:LIKE' => '%'.$query.'%'
//    ));
//}

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
