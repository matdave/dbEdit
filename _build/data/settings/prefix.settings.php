<?php
$setting = $modx->newObject('modSystemSetting');
$setting->fromArray(array(
    'key' => 'dbedit.prefix'
    ,'value' => ''
    ,'xtype' => 'textfield'
    ,'namespace' => PKG_NAME_LOWER
    ,'area' => ''
), '', true, true);

return $setting;
?>
