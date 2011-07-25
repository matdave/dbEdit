<?php
 
include dirname(dirname(__FILE__)).'/dbedit.config.php';

$js_url = $dbeditConfig['assetsUrl'].'components/dbedit/js/';

$modx->regClientStartupScript($js_url.'mgr/dbedit.js');
$modx->regClientStartupScript($js_url.'mgr/sections/edit_records.js');

$output = '<div id="dbedit-panel-records-div"></div>';

$modx->regClientStartupHTMLBlock('<script type="text/javascript">
Ext.onReady(function() {
    Dbedit.config = '.$modx->toJSON($dbeditConfig).';
    getTables();    
});
</script>');

return $output;
?>
