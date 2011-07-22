<?php
$permissions = array();

$permissions[] = $modx->newObject('modAccessPermission',array(
    'name' => 'gears.view_support',
    'description' => 'Allows users to see the support menu.',
    'value' => true,
));

$permissions[] = $modx->newObject('modAccessPermission',array(
    'name' => 'gears.view_siteschedule',
    'description' => 'Allows users to see the site schedule report.',
    'value' => true,
));

$permissions[] = $modx->newObject('modAccessPermission',array(
    'name' => 'gears.view_logout',
    'description' => 'Allows users to see the "logout" option in the site menu.',
    'value' => true,
));

return $permissions;
?>
