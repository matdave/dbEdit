<?php
$group = $modx->newObject('modUserGroup');
$group->set('id', 1);
$group->set('name','GearsManager');
$group->set('description', 'Manager Security Group.');
$group->set('parent', 0);

return $group;
?>
