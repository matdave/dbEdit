<?php
/**
 * Define the MODX path constants necessary for installation
 *
 * @package gears
 * @subpackage build
 */
define('MODX_BASE_PATH', dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/');
define('MODX_CORE_PATH', MODX_BASE_PATH . 'core/');
define('MODX_MANAGER_PATH', MODX_BASE_PATH . 'public_html/gears/');
define('MODX_CONNECTORS_PATH', MODX_BASE_PATH . 'public_html/connectors/');
define('MODX_ASSETS_PATH', MODX_BASE_PATH . 'public_html/assets/');

define('MODX_BASE_URL','/modx/');
define('MODX_CORE_URL', MODX_BASE_URL . 'core/');
define('MODX_MANAGER_URL', MODX_BASE_URL . 'gears/');
define('MODX_CONNECTORS_URL', MODX_BASE_URL . 'connectors/');
define('MODX_ASSETS_URL', MODX_BASE_URL . 'assets/');
?>