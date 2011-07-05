<?php
 
include(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'\dbedit.config.php');

$js_url = $assets_url.'components/dbedit/js/';

$modx->regClientStartupScript($js_url.'mgr/dbedit.js');
//$modx->regClientStartupHTMLBlock('<script type="text/javascript">
//Ext.onReady(function() {
//    Dbedit.config = \'\';
//});
//</script>');
$modx->regClientStartupScript($js_url.'mgr/widgets/schema.grid.js');
$modx->regClientStartupScript($js_url.'mgr/widgets/schema.panel.js');
$modx->regClientStartupScript($js_url.'mgr/sections/manage_schema.js');

$output = '<div id="dbedit-panel-schema-div"></div>';


//$results = $modx->query("SHOW TABLES LIKE 'user_%'");
//$tables = $results->fetchAll(PDO::FETCH_COLUMN);
//
//foreach($tables as $table)
//{
//    //$output .= $table.'<br />';    
//}

return $output;
?>
