<?php
if ($object->xpdo)
{
    switch ($options[xPDOTransport::PACKAGE_ACTION])
    {
        case xPDOTransport::ACTION_INSTALL:
            $modx =& $object->xpdo;
            $modx->setLogLevel(modX::LOG_LEVEL_ERROR);

            $resolverTag = '[Gears - Menu Permissions Resolver] ';
            
            $pairs = array(
                'support' => 'gears.view_support'
                ,'site_schedule' => 'gears.view_siteschedule'
                ,'logout' => 'gears.view_logout'
            );
            
            foreach($pairs as $menuText => $permission)
            {
                $menu = $modx->getObject('modMenu', array('text' => $menuText));
                
                if($menu)
                {
                    $menu->set('permissions', $permission);
                    $menu->save();
                }
                else{$modx->log(xPDO::LOG_LEVEL_ERROR, $resolverTag.'Could not find Menu:  '.$menuText.'!');}
            }
                        
            $modx->setLogLevel(modX::LOG_LEVEL_INFO);
            break;

        case xPDOTransport::ACTION_UPGRADE:
            break;
        
        case xPDOTransport::ACTION_UNINSTALL:

            $modx =& $object->xpdo;
            $modx->setLogLevel(modX::LOG_LEVEL_ERROR);

            $menus = array();
            $menus[] = $modx->getObject('modMenu', array('text' => 'support'));
            $menus[] = $modx->getObject('modMenu', array('text' => 'site_schedule'));
            $menus[] = $modx->getObject('modMenu', array('text' => 'logout'));

            foreach($menus as $menu)
            {
                if($menu)
                {
                    $permissions = explode(',', $menu->get('permissions'));

                    print_r($permissions);
    
                    foreach($permissions as $k => $v)
                    {
                        if(preg_match('/gears\./', $v) > 0)
                        {
                            unset($permissions[$k]);
                        }
                    }
                    $newPermissions = implode(',', $permissions);
    
                    $menu->set('permissions', $newPermissions);
                    $menu->save();
                }
                else{$modx->log(xPDO::LOG_LEVEL_INFO,'[gears] Could not find menu to remove permissions.  Skipping...');}
                
            }

            $modx->setLogLevel(modX::LOG_LEVEL_INFO);
            break;
    }
}
return true;
?>
