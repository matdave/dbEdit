<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tony
 * Date: 3/16/12
 * Time: 9:26 AM
 * To change this template use File | Settings | File Templates.
 */
class DbeditRecordsManagerController extends DbeditManagerController
{
    public function process(array $scriptProperties = array()){}

    public function getPageTitle()
    {
        return $this->modx->lexicon('dbedit.edit_records');
    }

    public function loadCustomCssJs()
    {
        $this->addLastJavascript($this->dbedit->config['jsUrl'].'mgr/sections/records.js');
    }

    public function getTemplateFile()
    {
        return $this->dbedit->config['templatesPath'].'records.tpl';
    }
}
