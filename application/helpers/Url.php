<?php
namespace application\helpers;

use application\models\product\Product;
use application\models\subscription\DownloadManager;
use system\basic\Config;
use system\basic\Registry;
use system\basic\Router;

/**
 * Class Url - helper for creating valid urls
 * @package application\helpers
 */
class Url {

    /**
     * @var array parsed routes
     */
    private static $_parsedRoutes = array();

    /**
     * primary method for creating urls
     * @param $controller
     * @param null $action
     * @param array $params
     * @param bool $checkRoutes
     * @return string
     */
    public static function _($controller, $action = null, $params = array(), $checkRoutes = true)
    {
        self::setRoutes();

        $queryString =  '/' . $controller . '/' . ($action ? $action . '/' : '');
        if (is_array($params) && count($params) > 0) {
            foreach($params as $key => $val) {
                $queryString .= $key . '/' . $val . '/';
            }
        }

        $routedString = $queryString;
        if ($checkRoutes) {
            // loop through roots, considering keys as destination and values as inputs
            foreach (self::$_parsedRoutes as $baseRoute => $destRoute) {
                if (preg_match('#^'.$baseRoute.'$#', $routedString, $match)) {
                    if (strpos($destRoute, '$') !== FALSE AND strpos($baseRoute, '(') !== FALSE)  {
                        $routedString = preg_replace('#^'.$baseRoute.'$#', $destRoute, $routedString);
                        break;
                    }
                }
            }
        }

        return self::getMainUrl() . ltrim($routedString, '/');
    }

    /**
     * set routes for parsing
     * @return void
     */
    public static function setRoutes()
    {
        if (!self::$_parsedRoutes) {
            $cache = Registry::get('cache');
            if ($cache && $routes = $cache->load('parsed_routes')) {
                self::$_parsedRoutes = $routes;
            } else {
                $router = Router::getInstance();
                $parsedRoutes = $router->getParsedRoutes();
                foreach ($parsedRoutes as $key => $val) {
                    preg_match_all('/\([a-zA-Z0-9-_|.\[\]\+]+\)/', $key, $matchesKeys);
                    preg_match_all('/\$[0-9]+/', $val, $matchesVals);
                    foreach ($matchesKeys[0] as $i => $match) {
                        $key = str_replace($match, $matchesVals[0][$i], $key);
                        $val = str_replace($matchesVals[0][$i], $match, $val);
                    }
                    self::$_parsedRoutes[$val] = $key;
                }
                if ($cache) {
                    $cache->save('parsed_routes', self::$_parsedRoutes);
                }
            }
        }
    }

    /**
     * returns correct domain url without subdomain part
     * @return string
     */
    public static function getMainUrl()
    {
        return 'http://' . $_SERVER['SERVER_NAME'] . '/';
    }

    /**
     * @param null $cityAlias
     * @return string
     */
    public static function getDrugstoresUrl($cityAlias = null)
    {
        if (!empty($cityAlias)) {
            $params = array('city' => $cityAlias);
        } else {
            $params = array();
        }
        return self::_('drugstores', '', $params);
    }
}