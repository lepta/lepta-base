<?php
namespace application\models;

use system\db\ActiveRecord;

/**
 * Class Seo
 * @package application\models\seo
 */
abstract class Seo extends ActiveRecord
{
    /**
     * @var string meta title
     */
    protected $_title;

    /**
     * @var string meta description
     */
    protected $_description;

    /**
     * @var string meta keywords
     */
    protected $_keywords;

    /**
     * @var string meta robots
     */
    protected $_robots;

    /**
     * inits corresponding SEO object, fills properties with data
     * @param $object
     * @return void
     */
    abstract public function init($object);

    /**
     * returns all metadata as an array
     * @return array
     */
    public function getMetaData()
    {
        return array(
            'title' => $this->_title,
            'description' => $this->_description,
            'keywords' => $this->_keywords,
            'robots' => $this->_robots
        );
    }

    /**
     * returns single meta param
     * @param $paramName
     * @return string | null
     */
    public function getMetaParam($paramName)
    {
        return $this->$paramName;
    }

    /**
     * magic getter
     * @param $paramName
     * @return string
     */
    public function __get($paramName)
    {
        $paramName = '_' . $paramName;
        if (property_exists(get_called_class(), $paramName)) {
            return $this->$paramName;
        } else {
            return null;
        }
    }
}