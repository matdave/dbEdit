<?php
include(dirname(dirname(dirname(dirname(__FILE__)))) . '/core/config/config.inc.php');
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';

$modx = new modX();
$modx->initialize('mgr');

$results = $modx->query("SHOW TABLES NOT LIKE 'modx_%'");
$tables = $results->fetchAll(PDO::FETCH_COLUMN);

print_r($tables);

foreach($tables as $table)
{
    echo $table.'<br />';
}
?>
