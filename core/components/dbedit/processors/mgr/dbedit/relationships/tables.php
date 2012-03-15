<?php
// Get our custom prefix from the modx setting
$prefix = $modx->getOption('dbedit.prefix');

// Get all of our tables that have our custom prefix
$results = $modx->query("SHOW TABLES LIKE '".$prefix."%'");
$tables = $results->fetchAll();

$names = array();

foreach($tables as $table)
{
    $names[] = array('class' => tableToClassName($table[0]));
}

return $this->outputArray($names);

// This function parses the table name to build the correct xPDO class name
function tableToClassName($tableName)
{
    $arrName = explode('_', $tableName);

    unset($arrName[0]);

    foreach($arrName as &$name)
    {
        $name = ucfirst($name);
    }

    return implode('', $arrName);
}