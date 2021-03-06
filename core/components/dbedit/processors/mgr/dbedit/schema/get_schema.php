<?php
$prefix = $modx->getOption('dbedit.prefix');

$results = $modx->query("SHOW TABLES LIKE '".$prefix."%'");

$tables = $results->fetchAll();

$arrTables = array();

foreach($tables as $table)
{
    $arrTable = array('table_name' => $table[0]);

    $arrName = explode('_', $table[0]);

    unset($arrName[0]);

    foreach($arrName as &$name)
    {
        $name = ucfirst($name);
    }

    $table = implode('', $arrName);
    $tester = $modx->getTableName(ucfirst($table));
    if($tester == '')
    {
        $arrTable['has_schema'] = false;
    }
    else
    {
        $arrTable['has_schema'] = true;
    }
    $arrTables[] = $arrTable;
}

return $this->outputArray($arrTables);
?>
