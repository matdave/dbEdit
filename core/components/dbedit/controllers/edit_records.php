<?php
 
include(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'\dbedit.config.php');

$js_url = $assets_url.'components/dbedit/js/';

$modx->regClientStartupScript($js_url.'mgr/dbedit.js');
//$modx->regClientStartupScript($js_url.'mgr/widgets/records.grid.js');
//$modx->regClientStartupScript($js_url.'mgr/widgets/records.panel.js');
$modx->regClientStartupScript($js_url.'mgr/sections/edit_records.js');


//$modx->regClientStartupHTMLBlock('<div id="tony">My HTML Block</div>');
//$modx->regClientStartupHTMLBlock('<script type="text/javascript">
//Ext.onReady(function() {
//    Dbedit.config = \'\';
//});
//</script>');
//
//$modx->regClientHTMLBlock( 
//    include $core_path.'components/dbedit/js/mgr/widgets/records.grid.js.php'   
//);
//
//$modx->regClientHTMLBlock(
//    include $core_path.'components/dbedit/js/mgr/widgets/records.panel.js.php'    
//);

$output = '<div id="dbedit-panel-records-div"></div>';

return $output;
?>
