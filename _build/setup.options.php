<?php

$values = array(
'prefix' => 'custom_'
);

switch ($options[xPDOTransport::PACKAGE_ACTION]) {
case xPDOTransport::ACTION_INSTALL:
case xPDOTransport::ACTION_UPGRADE:
    $setting = $modx->getObject('modSystemSetting',array('key' => 'dbedit.prefix'));
    if ($setting != null) { $values['prefix'] = $setting->get('value'); }
    unset($setting);

    break;
case xPDOTransport::ACTION_UNINSTALL: break;
}

$output = '<label for="dbedit-prefix">Custom Table Prefix:</label>
<input type="text" name="prefix" id="dbedit-prefix" width="300" value="'.$values['prefix'].'" />
<br /><br />';

return $output;