<?php
echo "HEY";

/*$isLimit = !empty($scriptProperties['limit']);
$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,10);
$sort = $modx->getOption('sort',$scriptProperties,'name');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');
$query = $modx->getOption('query', $scriptProperties, '');
 
$prefix = $modx->getOption('dbedit.prefix');

$results = $modx->query("SHOW TABLES LIKE '".$prefix."%'");
$tables = $results->fetchAll();

$arrTables = array();

require_once 'xpdo.config.php';

foreach($tables as $table)
{
    // Generate the xPDO class name for the table
    $arrName = explode('_', $table[0]);

    unset($arrName[0]);

    foreach($arrName as &$name)
    {
        $name = ucfirst($name);
    }

    $tableName = implode('', $arrName);

    // Test to see if the class has an associated table
    // $tester = $xpdo->getTableName(ucfirst($arrName[1]));
    $tester = $xpdo->getTableName($tableName);


    // If the class doesn't have an associated table, then its schema hasn't been generated yet,
    // so we don't return it to CMP
    if($tester != '')
    {
        $results = $modx->query("SHOW TABLE STATUS LIKE '".$table[0]."'");
        $rows = $results->fetchAll();

        foreach($rows as $row)
        {
            $results = $modx->query("SHOW FULL COLUMNS FROM $table[0]");
            $columns = $results->fetchAll();

            $arrColumns = array();
            foreach($columns as $column)
            {
                $arrColumns[] = $column;
            }

            $arrTable['info'] = $row;
            $arrTable['columns'] = $arrColumns;
            $arrTables[] = $arrTable;

        }
    }
}

print_r($arrTables);*/

//return $this->outputArray($arrTables);
?>
