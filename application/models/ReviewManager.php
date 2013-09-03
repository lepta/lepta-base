<?php
namespace application\models;

use system\db\ActiveRecord;

/**
 * Class ReviewManager
 * @package application\models
 */
class ReviewManager extends ActiveRecord {

    /**
     * @return array
     */
    public function getList()
    {
        $qb = $this->db->getQueryBuilder()->from('reviews')->where(array('is_active' => 1))->order('timestamp');
        $reviews = $this->db->fetchAll($qb);
        if ($reviews) {
            foreach($reviews as &$review) {
                $review['image'] = '/userfiles/reviews/' . $review['img'];
                unset($review['img']);
            }
        }
        return $reviews ? $reviews : array();
    }
}