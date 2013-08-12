<?php
namespace application\models;

use system\db\ActiveRecord;

/**
 * Class Faq
 * @package application\models
 */
class Faq extends ActiveRecord
{
    /**
     * @var string
     */
    protected $_table = 'faq';

    /**
     * returns list of questions/answers
     * @return array
     */
    public function getList()
    {
        $query = $this->db->getQueryBuilder()
                          ->from('faq', array('question', 'answer'))
                          ->where(array('is_visible' => 1));
        $rows = $this->db->fetchAll($query);
        return $rows ? $rows : array();
    }
}