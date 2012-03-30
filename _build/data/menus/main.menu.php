<?php
$menu = $modx->newObject('modMenu');
$menu -> fromArray(array(
    'text' => 'dbedit'
    ,'description' => 'dbedit.desc'
    ,'icon' => 'images/icons/database.png'
), '', true, true);

return $menu;
?>
