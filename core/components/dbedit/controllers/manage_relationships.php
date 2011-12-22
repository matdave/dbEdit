<?php
 
include dirname(dirname(__FILE__)).'/dbedit.config.php';

$js_url = $dbeditConfig['assetsUrl'].'components/dbedit/js/';

$modx->regClientStartupScript($js_url.'mgr/dbedit.js');
$modx->regClientStartupScript($js_url.'mgr/sections/manage_relationships.js');

$output = '<div id="dbedit-panel-relationships-div"></div>';

$modx->regClientStartupHTMLBlock('<script type="text/javascript">
Ext.onReady(function() {
    Dbedit.config = '.$modx->toJSON($dbeditConfig).';
    buildPage();
});
</script>');

return $output;
?>
