<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage PluginsFunction
 */

/**
 * Smarty {urlbuilder} function plugin
 *
 * Type:     function<br>
 * Name:     counter<br>
 * Purpose:  print out a counter value
 *
 * @author Og
 * @param array                    $params   parameters
 * @param Smarty_Internal_Template $template template object
 * @return string|null
 */
function smarty_function_urlbuilder($params, $template)
{
    $url = '';
	if (count($params) > 0) {
        switch($params['section']) {
            case 'main':
                $url = \application\helpers\Url::getMainUrl();
                break;
            case 'drugstores':
                $url = \application\helpers\Url::getDrugstoresUrl();
                break;
            default:
                $url = '';
                break;
        }
    }
	return $url;
}