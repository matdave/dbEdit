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


$prefix = $modx->getOption('dbedit.prefix');

$results = $modx->query("SHOW TABLES LIKE '".$prefix."%'");
$tables = $results->fetchAll();

$arrTables = array();

foreach($tables as $table)
{
    $results = $modx->query("SHOW TABLE STATUS LIKE '".$table[0]."'");
    $rows = $results->fetchAll();   
    
    foreach($rows as $row)
    {
        
        //echo '<h2>'.$row['Comment'].'</h2>';
        $results = $modx->query("SHOW FULL COLUMNS FROM $table[0]");
        $columns = $results->fetchAll();

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
echo '</pre>';


return $this->outputArray($arrTables);
?>
