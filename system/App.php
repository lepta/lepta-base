<?php
namespace system;

use system\basic\BaseErrorController;
use system\basic\Exceptions\BadClassInstantiationException;
use system\basic\Registry;
use \system\basic\Request;
use \system\basic\Response;
use \system\basic\Router;
use \system\basic\Config;
use \system\basic\Exceptions\MissingClassException;
use system\basic\exceptions\BaseException;
use system\cache\CacheFactory;
use system\cache\driver\NullCacheDriver;
use system\db\DbDriverFactory;
use system\logger\LoggerFactory;

/**
 * Class App is the main application class. It inits the whole app
 *
 * @package system
 */
class App
{
    /**
     * @var App
     */
    private static $_instance;

    /**
     * @var Request
     */
    private $_request;

    /**
     * @var Response
     */
    private $_response;

    /**
     * @var Router
     */
    private $_router;

    private function __construct(){}

    private function __clone(){}

    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
            self::$_instance->_init();
        }
        return self::$_instance;
    }

    private function _init()
    {
        $this->_request = Request::getInstance();
        $this->_response = Response::getInstance();
        $this->_router = Router::getInstance();
    }

    private function _dispatch($controllerName, $actionName)
    {
        try {
            $controllerClassName = '\\application\\controllers\\' . ucfirst($controllerName) . 'Controller';
            $controller = new $controllerClassName( $this );
            try {
                $controller->_preDispatch();
                $controller->$actionName();
                $controller->_postDispatch();
                $controller->display();
            } catch (BaseException $e) {
                $errorController = new BaseErrorController( $this );
                $errorController->renderErrorPageAction( $e );
                $errorController->display();
            }
        } catch (MissingClassException $e) {
            $exception = new MissingClassException($e->getMessage(), 404, $e);
            $errorController = new BaseErrorController( $this );
            $errorController->renderErrorPageAction( $exception );
            $errorController->display();
        }
    }

    /**
     * @param array $autoloadConfig
     * @todo refactor, make automated and configurable
     * @return void
     */
    private function _loadModules(array $autoloadConfig)
    {
        if (in_array('database', $autoloadConfig)) {
            try {
                $databaseDriver = DbDriverFactory::factory( Config::getSectionParam('db', 'driver') );
                // store autoloaded driver to the database
                Registry::set('dbdriver', $databaseDriver);
            } catch (BadClassInstantiationException $e) {
                //die($e->getMessage());
            }
        }
        if (in_array('cache', $autoloadConfig)) {
            try {
                $cacheDriver = CacheFactory::factory( Config::getSectionParam('cache', 'driver') );
                Registry::set('cache', $cacheDriver);
            } catch(BadClassInstantiationException $e) {
                die( $e->getMessage() );
            }
        } else {
            Registry::set('cache', new NullCacheDriver());
        }

        if (in_array('logger', $autoloadConfig)) {
            try {
                $loggerAdapter = LoggerFactory::factory( Config::getSectionParam('logger', 'destination'));
                Registry::set('logger', $loggerAdapter);
            } catch (BadClassInstantiationException $e) {
                die ( $e->getMessage() );
            }
        }
    }

    /**
     *
     */
    public function run()
    {
        /**
         * start collection all the output information into the output buffer
         */
        $this->_response->startOutput();
        /**
         * start processing the incoming request
         */
        $this->_request->processRequest();
        /**
         * set the routes for the Router
         */
        $this->_router->setRoutingConfig( Config::getSection('routes', false) );

        /**
         * start routing process. Define Controller, Action and action params
         */
        $this->_router->route( $this->_request );

        /**
         * autoload
         */
        $this->_loadModules( Config::getSection('autoload') );
        /**
         * dispatch the call to the corresponding controller and its action
         */
        $this->_dispatch( $this->_router->getController(), $this->_router->getAction() );

        /**
         * end up displaying what we have just rendered
         */
        $this->_response->getOutput();
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->_request;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->_response;
    }

    /**
     * @return Router
     */
    public function getRouter()
    {
        return $this->_router;
    }
}