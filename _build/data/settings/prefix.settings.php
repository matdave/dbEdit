<?php
$setting = $modx->newObject('modSystemSetting');
$setting->fromArray(array(
    'key' => 'dbedit.prefix'
    ,'value' => 'user_'
    ,'xtype' => 'textfield'
    ,'namespace' => PKG_NAME_LOWER
    ,'area' => ''
), '', true, true);

return $setting;
?>
