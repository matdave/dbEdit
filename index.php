<?php
include(dirname(dirname(dirname(dirname(__FILE__)))) . '/core/config/config.inc.php');
//require_once MODX_CORE_PATH . 'xpdo/xpdo.class.php';
//
//$xpdo = new xPDO($database_dsn, $database_user, $database_password, array(xPDO::OPT_TABLE_PREFIX => 'user_'));
//
//$modelPath = MODX_CORE_PATH . 'components/dbedit/model/';
//
//$xpdo->addPackage('dbedit', $modelPath);
//
//$tony = $xpdo->getObject('Dbedit', array('id' => 1));
//echo $tony->get('first');
//
//$edit = $xpdo->newObject('Dbedit');
//
//$edit->fromArray(array(
//    'first' => 'Julie'
//    ,'last' => 'Fahrlander'
//    ,'address1' => 'Somwhere'
//    ,'address2' => 'In Crete'
//    ,'city' => 'Crete'
//    ,'state' => 'NE'
//    ,'zip' => 68333
//));
//
//$edit->save();

require_once MODX_CORE_PATH . 'xpdo/xpdo.class.php';

$xpdo = new xPDO($database_dsn, $database_user, $database_password, array(xPDO::OPT_TABLE_PREFIX => 'user_'));

$modelPath = MODX_CORE_PATH . 'components/dbedit/model/';

$xpdo->addPackage('dbedit', $modelPath);

/* build query */
$c = $xpdo->newQuery('Dbedit');

if(!empty($query))
{
    $c->where(array(
        'name:LIKE' => '%'.$query.'%'
    ));
}

$count = $xpdo->getCount('Dbedit',$c);
//$c->sortby($sort,$dir);
//if ($isLimit) $c->limit($limit,$start);
$dbedits = $xpdo->getIterator('Dbedit', $c);
 
/* iterate */
$list = array();
foreach ($dbedits as $dbedit) 
{
    $dbeditArray = $dbedit->toArray();   
    $list[]= $dbeditArray;
}
print_r($list);
?>
