<?php
/**
 * configuration file containing information about the template engine being used
 * @author Oleg Cherevko
 */

/**
 *
 */
$templateengineCfg['engine'] = 'Smarty';

$templateengineCfg['smarty'] = array(
    'cache_dir' => '_cache/smarty/cache/',
    'compiled_dir'  => '_cache/smarty/compiled/',
    'templates_dir' => 'application/views/',
    'plugins_dir' => 'application/views/_plugins/'
);
