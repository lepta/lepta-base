<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Администратор
 * Date: 19.07.13
 * Time: 8:42
 * To change this template use File | Settings | File Templates.
 */

namespace application\models;


use system\db\ActiveRecord;

/**
 * Class Review
 * @package application\models
 */
class Review extends ActiveRecord {
    /**
     * @var string
     */
    protected $_table = 'reviews';

    /**
     * @var string
     */
    protected $_key = 'id';
}