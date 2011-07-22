<?php
if ($object->xpdo)
{
    switch ($options[xPDOTransport::PACKAGE_ACTION])
    {
        case xPDOTransport::ACTION_INSTALL:
            $modx =& $object->xpdo;
            $modx->setLogLevel(modX::LOG_LEVEL_ERROR);

            $resolverTag = '[Gears - Settings Resolver] ';
            
            // Set the manager theme to Gears
            $theme = $modx->getObject('modSystemSetting', 'manager_theme');
            if($theme)
            {
                $theme->set('value', 'gears');
                $theme->save();
            }
            else{$modx->log(xPDO::LOG_LEVEL_ERROR, $resolverTag.'Could not find Manager Theme Setting!');}

            // Don't use Compressed CSS
            $css = $modx->getObject('modSystemSetting', 'compress_css');
            if($css)
            {
                $css->set('value', 0);
                $css->save();
            }
            else{$modx->log(xPDO::LOG_LEVEL_ERROR, $resolverTag.'Could not find Compress CSS Setting!');}
            
            // Set the default file manager directory
            $filemgr = $modx->getObject('modSystemSetting', 'filemanager_path');
            if($filemgr)
            {
                $filemgr->set('value', 'assets/site');
                $filemgr->save();
            }
            else{$modx->log(xPDO::LOG_LEVEL_ERROR, $resolverTag.'Could not find File Manager Path Setting!');}

            // Set the values of custom system settings with the appropriate page IDs
            $pairs = array(
                'gears.contactUsThankYouPageId' => 'Thanks for contacting us!'
                ,'gears.searchResultsId' => 'Search Results'
                ,'gears.newsId' => 'Latest News'
            );
            
            foreach($pairs as $key => $pageTitle)
            {
                $setting = $modx->getObject('modSystemSetting', $key);
                $page = $modx->getObject('modResource', array('pagetitle' => $pageTitle));
                
                if($page)
                {
                    if($setting)
                    {
                        $setting->set('value', $page->get('id'));
                        $setting->save();
                    }
                    else{$modx->log(xPDO::LOG_LEVEL_ERROR, $resolverTag.'Could not find setting:  '. $key .'!');}
                }
                else{$modx->log(xPDO::LOG_LEVEL_ERROR, $resolverTag.'Could not find page:  '. $pageTitle .'!');}
            }
                      
            
            $modx->setLogLevel(modX::LOG_LEVEL_INFO);
            break;
            
        case xPDOTransport::ACTION_UPGRADE:
            break;
            
        case xPDOTransport::ACTION_UNINSTALL:
            
            $modx =& $object->xpdo;
            $modx->setLogLevel(modX::LOG_LEVEL_ERROR);

            // Reset the manager theme to default
            $theme = $modx->getObject('modSystemSetting', 'manager_theme');
            if($theme)
            {
                $theme->set('value', 'default');
                $theme->save();
            }
            else{$modx->log(xPDO::LOG_LEVEL_ERROR, $resolverTag.'Could not find Manager Theme Setting!');}

            // Reset to use compressed css
            $css = $modx->getObject('modSystemSetting', 'compress_css');
            if($css)
            {
                $css->set('value', 1);
                $css->save();
            }
            else{$modx->log(xPDO::LOG_LEVEL_ERROR, $resolverTag.'Could not find Compress CSS Setting!');}
            
            // Reset the default file manager directory
            $filemgr = $modx->getObject('modSystemSetting', 'filemanager_path');
            if($filemgr)
            {
                $filemgr->set('value', '/');
                $filemgr->save();
            }
            else{$modx->log(xPDO::LOG_LEVEL_ERROR, $resolverTag.'Could not find File Manager Path Setting!');}

            $modx->setLogLevel(modX::LOG_LEVEL_INFO);
            break;
    }
}
return true;
?>
