<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage PluginsFunction
 */

/**
 * Smarty {selectbuilder} function plugin
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
function smarty_function_selectbuilder($params, $template)
{
    $items = $params['items'];
    $active = $params['active'] ? $params['active'] : null;
    $class = $params['class'];
    $id = $params['id'];
    $name = $params['name'];
    $prepend = $params['prepend'];
    if ($prepend) {
        array_unshift($items, $prepend);
    }
    $options = '';
    foreach ($items as $key => $value) {
        if (!empty($active) && $active == $key) {
            $options .= '<option value="' . $key . '" selected>' . $value . '</option>';
        } else {
            $options .= '<option value="' . $key . '">' . $value . '</option>';
        }
    }
    return '<select ' . ($name ? 'name="' . $name . '"' : '') . ' ' . ($class ? 'class="' . $class . '"' : '') . ' ' . ($id ? 'id="' . $id . '"' : '') . ' >' . $options . '</select>';
}