<?php
$profile = include dirname(__FILE__).'/transport.userprofile.php';

$user = $modx->newObject('modUser');
$user->set('id', 1);
$user->set('username','manager');
$user->set('password','manager');
$user->set('class_key','modUser');
$user->set('active',1);

$user->addOne($profile);

return $user;
?>
