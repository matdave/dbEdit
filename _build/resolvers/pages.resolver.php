<?php
if ($object->xpdo)
{
    switch ($options[xPDOTransport::PACKAGE_ACTION])
    {
        case xPDOTransport::ACTION_INSTALL:
            $modx =& $object->xpdo;
            $modx->setLogLevel(modX::LOG_LEVEL_ERROR);

            $resolverTag = '[Gears - Pages Resolver] ';
            
            // Set the Appropriate templates for pages
            $pairs = array(
                'Contact Us' => 'Contact Page Template'
                ,'Thanks for contacting us!' => 'Inside Page Template'
                ,'Search Results' => 'Inside Page Template'
                ,'Sitemap' => 'Inside Page Template'
                ,'News Archive' => 'Inside Page Template'
                ,'Latest News' => 'News Page Template'
                ,'Home' => 'Home Page Template'
                ,'The page you are looking for does not exist' => 'Inside Page Template'
            );
            
            foreach($pairs as $pageTitle => $tplName)
            {
                $page = $modx->getObject('modResource', array('pagetitle' => $pageTitle));
                $template = $modx->getObject('modTemplate', array('templatename' => $tplName));
                
                if($page)
                {
                    if($template)
                    {
                        $page->addOne($template);
                        $page->save();
                    }
                    else{$modx->log(xPDO::LOG_LEVEL_ERROR, $resolverTag.'Could not find Template:  ' . $tplName . '!');}
                }
                else{$modx->log(xPDO::LOG_LEVEL_ERROR, $resolverTag.'Could not find Page:  ' . $pageTitle . '!');}
            }     
            unset($pairs, $page, $template, $tplName, $pageTitle);
            
            //SPECIFIC TO NEWS - set the News Weblink as the parent of Latest News and Archive
            $parent = $modx->getObject('modWebLink', array('pagetitle' => 'News'));
            $children = array('Latest News', 'News Archive');
            if($parent)
            {
                if(is_array($children))
                {
                    foreach($children as $child)
                    {                        
                        $page = $modx->getObject('modResource', array('pagetitle' => $child));

                        if($page)
                        {
                            $page->addOne($parent, 'Parent');
                            $page->save();
                        }
                        else{$modx->log(xPDO::LOG_LEVEL_ERROR, $resolverTag.'Could not find Page:  ' . $child . '!');}
                    }
                }
                else{$modx->log(xPDO::LOG_LEVEL_ERROR, $resolverTag.'Not a valid array of child pages!');}
            }
            else{$modx->log(xPDO::LOG_LEVEL_ERROR, $resolverTag.'Could not find News Weblink!');}
            
            $modx->setLogLevel(modX::LOG_LEVEL_INFO);
            break;

        case xPDOTransport::ACTION_UPGRADE:
            break;
            
        case xPDOTransport::ACTION_UNINSTALL:
            break;
    }
}
return true;
?>
