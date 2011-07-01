<?php
 
$js_url = '/trans_pkgs/dbedit/assets/components/dbedit/js/';

$modx->regClientStartupScript($js_url.'mgr/dbedit.js');
//$modx->regClientStartupHTMLBlock('<script type="text/javascript">
//Ext.onReady(function() {
//    Dbedit.config = \'\';
//});
//</script>');
$modx->regClientStartupScript($js_url.'mgr/widgets/records.grid.js.php');
$modx->regClientStartupScript($js_url.'mgr/widgets/records.panel.js.php');
$modx->regClientStartupScript($js_url.'mgr/sections/edit_records.js');

$output = '<div id="dbedit-panel-records-div"></div>';


//$results = $modx->query("SHOW TABLES LIKE 'user_%'");
//$tables = $results->fetchAll(PDO::FETCH_COLUMN);
//
//foreach($tables as $table)
//{
//    //$output .= $table.'<br />';    
//}

return $output;
?>
