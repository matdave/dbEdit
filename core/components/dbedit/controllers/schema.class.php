<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tony
 * Date: 3/16/12
 * Time: 9:26 AM
 * To change this template use File | Settings | File Templates.
 */
class DbeditSchemaManagerController extends DbeditManagerController
{
    public function process(array $scriptProperties = array()){}

    public function getPageTitle()
    {
        return $this->modx->lexicon('dbedit.schema_manage');
    }

    public function loadCustomCssJs()
    {
        $this->addLastJavascript($this->dbedit->config['jsUrl'].'mgr/sections/schema.js');
    }

    public function getTemplateFile()
    {
        return $this->dbedit->config['templatesPath'].'schema.tpl';
    }
}
