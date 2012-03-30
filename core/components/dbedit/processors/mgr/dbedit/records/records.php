<?php
$isLimit = !empty($scriptProperties['limit']);

$pri_key = $modx->getOption('tablePriKey', $scriptProperties, 'id');

$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,10);
$sort = $modx->getOption('sort',$scriptProperties,$pri_key);
$dir = $modx->getOption('dir',$scriptProperties,'ASC');
$query = $modx->getOption('query', $scriptProperties, '');
$class = $this->getProperty('tableClass');

/* build query */
$c = $modx->newQuery($class);

$c->sortby($sort,$dir);

if(!empty($query))
{
    $arrColumns = $modx->getFields($class);

    $arrWhere = array();

    $first = true;
    foreach($arrColumns as $key => $value)
    {
        $arrWhere[($first ? '' : 'OR:').$key.':LIKE'] = '%'.$query.'%';
        $first = false;
    }

    $c->where($arrWhere);
}

$count = $modx->getCount($class,$c);

if ($isLimit) $c->limit($limit,$start);

$records = $modx->getCollection($class, $c);

/* iterate */
$list = array();
foreach ($records as $record)
{
    $recordArray = $record->toArray();
    $list[]= $recordArray;
}
return $this->outputArray($list,$count);

