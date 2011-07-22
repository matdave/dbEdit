<?php
if ($object->xpdo)
{
    switch ($options[xPDOTransport::PACKAGE_ACTION])
    {
        case xPDOTransport::ACTION_INSTALL:
            $modx =& $object->xpdo;
            $modx->setLogLevel(modX::LOG_LEVEL_INFO);
           
            $resolverTag = '[Gears - Policy Resolver] ';
            
            /* assign policy to Manager group */
            $policy = $modx->getObject('modAccessPolicy',array('name' => 'GearsManagerPolicy'));
            $mgrGroup = $modx->getObject('modUserGroup',array('name' => 'GearsManager'));
            
            if ($policy)
            {
                if($mgrGroup)
                {
                    $arrAcWeb = array(
                        'target' => 'web',
                        'principal_class' => 'modUserGroup',
                        'principal' => $mgrGroup->get('id'),
                        'authority' => 9999,
                        'policy' => $policy->get('id'),
                    );

                    $arrAcMgr = array(
                        'target' => 'mgr',
                        'principal_class' => 'modUserGroup',
                        'principal' => $mgrGroup->get('id'),
                        'authority' => 9999,
                        'policy' => $policy->get('id'),
                    );

                    $mgr = $modx->getObject('modAccessContext',$arrAcMgr);
                    $web = $modx->getObject('modAccessContext',$arrAcWeb);

                    if (!$mgr)
                    {
                        $mgr = $modx->newObject('modAccessContext');
                        $mgr->fromArray($arrAcMgr);
                        $mgr->save();
                    }

                    if (!$web)
                    {
                        $web = $modx->newObject('modAccessContext');
                        $web->fromArray($arrAcWeb);
                        $web->save();
                    }
                }
                else{$modx->log(xPDO::LOG_LEVEL_ERROR, $resolverTag.'Could not find Manager Access Group!');}
            }
            else{$modx->log(xPDO::LOG_LEVEL_ERROR, $resolverTag.'Could not find Manager Acess Policy!');}
            
            break;
        case xPDOTransport::ACTION_UPGRADE:
           
            break;
        case xPDOTransport::ACTION_UNINSTALL:
            
            break;
    }
}
return true;
?>
