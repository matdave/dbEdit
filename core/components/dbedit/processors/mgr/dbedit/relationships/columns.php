<?php

$arrFieldMeta = $modx->getFieldMeta($this->getProperty('class'));
$arrCols = array();

foreach($arrFieldMeta as $key => $value)
{
    $arrCols[] = array('column' => $key);
}

return $this->outputArray($arrCols);


