<?php
$userProfile = $modx->newObject('modUserProfile');
$userProfile->set('fullname','Default Manager User');
$userProfile->set('email','admin@ideabankmarketing.com');

return $userProfile;

?>
