<?php
$isLimit = !empty($scriptProperties['limit']);
$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,10);
$sort = $modx->getOption('sort',$scriptProperties,'name');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');
$query = $modx->getOption('query', $scriptProperties, '');
 
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

return $this->outputArray($arrTables);
?>
