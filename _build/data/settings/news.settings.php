<?php
$setting = $modx->newObject('modSystemSetting');
$setting->fromArray(array(
    'key' => 'gears.newsId'
    ,'value' => ''
    ,'xtype' => 'textfield'
    ,'namespace' => PKG_NAME_LOWER
    ,'area' => 'Page ID'
), '', true, true);

return $setting;
?>
