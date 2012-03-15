<?php
$isLimit = !empty($scriptProperties['limit']);
$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,10);
$sort = $modx->getOption('sort',$scriptProperties,'id');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');
$query = $modx->getOption('query', $scriptProperties, '');
$class = $modx->getOption('tableClass', $scriptProperties, '');
include 'xpdo.config.php';

/* build query */
$c = $xpdo->newQuery($class);

$c->sortby($sort,$dir);

if(!empty($query))
{
    $arrColumns = $xpdo->getFields($class);

    $arrWhere = array();

    $first = true;
    foreach($arrColumns as $key => $value)
    {
        $arrWhere[($first ? '' : 'OR:').$key.':LIKE'] = '%'.$query.'%';
        $first = false;
    }

    $c->where($arrWhere);
}

$count = $xpdo->getCount($class,$c);

if ($isLimit) $c->limit($limit,$start);

$records = $xpdo->getIterator($class, $c);

/* iterate */
$list = array();
foreach ($records as $record) 
{
    $recordArray = $record->toArray();   
    $list[]= $recordArray;
}
return $this->outputArray($list,$count);
?>
