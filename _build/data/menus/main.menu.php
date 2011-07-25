<?php
$menu = $modx->newObject('modMenu');
$menu -> fromArray(array(
    'text' => 'Database Editor'
    ,'parent' => ''
    ,'description' => 'Use this to manage your custom tables.'
    ,'params' => ''
    ,'handler' => ''
), '', true, true);

return $menu;
?>
