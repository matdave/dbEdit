<?php
include 'config.core.php';

include MODX_CORE_PATH.'model/modx/modx.class.php';

$modx = new modX();
$modx->initialize('mgr');

include($modx->getOption('core_path').'config/config.inc.php');

//$xpdo = new xPDO($database_dsn, $database_user, $database_password, array(xPDO::OPT_TABLE_PREFIX => $modx->getOption('dbedit.prefix')));
//$modelPath = $modx->getOption('core_path') . 'components/dbedit/model/';
////$xpdo->addPackage('dbedit', $modelPath);

//$results = $xpdo->query("SHOW TABLES LIKE '".$prefix."%'");

//$tables = array('user_accounts', 'user_dbedit');
require_once 'core/components/dbedit/processors/mgr/dbedit/xpdo.config.php';

$prefix = $modx->getOption('dbedit.prefix');



$results = $modx->query("SHOW TABLES LIKE '".$prefix."%'");
$tables = $results->fetchAll(PDO::FETCH_NUM);

$arrTables = array();




$modelPath = $modx->getOption('core_path') . 'components/dbedit/model/';

$manager = $xpdo->getManager();
$generator = $manager->getGenerator();
$generator->parseSchema($modelPath.'schema/dbedit.mysql.schema.xml',$modelPath);

$xpdo->addPackage('dbedit', $modelPath);

/*$stu = $xpdo->getObject('Sfowner', array('name' => 'Stuart Wilsman'));

echo $stu->get('id');
echo '<br />'.$stu->get('name');
echo '<br />'.$stu->get('email');

$rightway = $xpdo->getObject('Sfstores', array('name' => 'Rightway Grocery'));

echo '<br />'.$rightway->get('id');
echo '<br />'.$rightway->get('name');*/


/*$arrClasses = array('Sfowner', 'Sfstores', 'Sfstoreowner');

foreach($arrClasses as $class)
{
    echo '<h2>'.$class.'</h2>';
    
    $soAggregates = $xpdo->getAggregates($class);
    echo 'Aggregates:  <pre>';
    print_r($soAggregates);
    echo '</pre>';

    $soAggregates = $xpdo->getComposites($class);
    echo 'Composites:  <pre>';
    print_r($soAggregates);
    echo '</pre>';
}*/

/*$soAggregates = $xpdo->getAggregates('Sfstoreowner');
echo '<pre>';
print_r($soAggregates);
echo '</pre>';

$soAggregates = $xpdo->getComposites('Sfstoreowner');
echo '<pre>';
print_r($soAggregates);
echo '</pre>';*/
/*echo '<br />';


$storeOwner = xPDOObject::getSelectColumns($xpdo, 'Sfstoreowner');
$arrColumns = str_replace('`', '', explode(',', $storeOwner));

print_r($arrColumns);

$tempSO = $xpdo->newObject('Sfstoreowner');

foreach($arrColumns as $column)
{
    echo '<br />'.$column.' - ';
    echo $tempSO->getFKClass(trim($column));
}
echo '<br />'.$tempSO->getFKClass('id');
echo '<br />'.$tempSO->getFKClass('store');
echo '<br />'.$tempSO->getFKClass('owner');*/






/*foreach($tables as $table)
{
    $results = $modx->query("SHOW TABLE STATUS LIKE '".$table[0]."'");
    $rows = $results->fetchAll(PDO::FETCH_ASSOC);
    
    foreach($rows as $row)
    {
        
        //echo '<h2>'.$row['Comment'].'</h2>';
        $results = $modx->query("SHOW FULL COLUMNS FROM $table[0]");
        $columns = $results->fetchAll(PDO::FETCH_ASSOC);

        $arrColumns = array();
        foreach($columns as $column)
        {
            $arrColumns[] = $column;
           // echo $column['Comment'].'<br />';

        }
        
        $arrTable['info'] = $row;
        $arrTable['columns'] = $arrColumns;
        $arrTables[] = $arrTable;
    }
}

echo '<pre>';
print_r($arrTables);
echo '</pre>';*/


//return $this->outputArray($arrTables);
?>
