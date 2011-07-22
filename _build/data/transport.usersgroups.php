<?php
$memberships = array();
$memberships[1] = $modx->newObject('modUserGroupMember');
$memberships[1]->set('id', 1);
$memberships[1]->set('role', 1);

$group = include dirname(__FILE__).'/transport.groups.php';

$user = include dirname(__FILE__).'/transport.users.php';

$memberships[1]->addOne($group);
$memberships[1]->addOne($user);

return $memberships;
?>
