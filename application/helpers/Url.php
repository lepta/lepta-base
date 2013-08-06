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
     * returns correct product url
     * @param $product
     * @param null $alias
     * @return string
     */
    public static function getProductUrl($product, $alias = null)
    {
        if (is_object($product) && $product instanceof \application\models\Product) {
            $productType = $product->type;
            $productAlias = $product->alias;
        } else {
            $productType = $product;
            $productAlias = $alias;
        }
        return self::_('product', 'index', array('type' => $productType, 'alias' => $productAlias));
    }

    /**
     * returns correct catalog url
     * @param string $type
     * @param null $category
     * @param null $page
     * @return string
     */
    public static function getCatalogUrl($type = 'powerpoint', $category = null, $page = null)
    {
        // build params
        if (empty($type)) {
            $params['type'] = 'powerpoint';
        } else {
            $params['type'] = $type;
        }
        if ($category) {
            $params['category'] = $category;
        }
        if ($page && is_numeric($page) && $page > 1) {
            $params['page'] = $page;
        }
        // prepare the result url
        return self::_('catalog', 'index', $params);
    }

    /**
     * returns correct search url
     * @param $searchText
     * @param string $type
     * @param null $page
     * @return string
     */
    public static function getSearchUrl($searchText, $type = 'powerpoint', $page = null)
    {
        $params = array(
            'type' => $type,
            'searchtext' => $searchText
        );
        if ($page && is_numeric($page) && $page > 1) {
            $params['page'] = (int)$page;
        }
        return self::_('search', 'index', $params);
    }

    /**
     * @param $pageAlias
     * @return string
     */
    public static function getStaticUrl($pageAlias)
    {
        return self::_('page', 'index', array('alias' => $pageAlias));
    }

    /**
     * @param null $profileAction
     * @return string
     */
    public static function getProfileUrl($profileAction = null)
    {
        return self::_('profile', $profileAction);
    }

    /**
     * builds correc registration url
     * @param $purchaseType
     * @return string
     */
    public static function getRegisrationUrl($purchaseType)
    {
        return self::_('profile', 'register', array('subscription' => $purchaseType));
    }

    /**
     * @return string
     */
    public static function getLoginUrl()
    {
        return self::_('login');
    }

    /**
     * @return string
     */
    public static function getSubscriptionUrl()
    {
        return self::_('subscription', null, null, false);
    }

    /**
     * @param $subscriptionType
     * @return string
     */
    public static function getPurchaseUrl($subscriptionType)
    {
        return self::_('order', 'buy', array('subscription' => $subscriptionType), false);
    }

    /**
     * builds link for external redirect
     * @param $url
     * @return string
     */
    public static function getExternalLink($url)
    {
        return self::_('out', $url);
    }

    /**
     * Product Download Link
     * @param $productId
     * @param $productAlias
     * @param $subscriptId
     * @return string
     */
    public static function getDownloadLink($productId, $productAlias, $subscriptId)
    {
        $key = DownloadManager::buildDownloadKey($productId, $subscriptId);
        return self::_('product', 'download', array('alias' => $productAlias, 'key' => $key));
    }

    /**
     * Link to Contact Us page
     * @return string
     */
    public static function getFeedbackUrl()
    {
        return self::_('contact-us');
    }
}