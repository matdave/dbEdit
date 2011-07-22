<?php
$setting = $modx->newObject('modSystemSetting');
$setting->fromArray(array(
    'key' => 'gears.searchResultsId'
    ,'value' => ''
    ,'xtype' => 'textfield'
    ,'namespace' => PKG_NAME_LOWER
    ,'area' => 'Page ID'
), '', true, true);

return $setting;
?>
