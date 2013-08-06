<?php
namespace application\models\seo;

use application\models\Leptaden;
use application\models\Seo;
use system\basic\exceptions\WrongInputParamsException;

/**
 * Class SeoStatic
 * @package application\models\seo
 */
class SeoLeptaden extends Seo {

    protected $_table = 'seo';
    /**
     * @param $page
     * @return mixed|void
     * @throws \system\basic\exceptions\WrongInputParamsException
     */
    public function init($page)
    {
        if (!($page instanceof Leptaden )) {
            throw new WrongInputParamsException("SeoStatic::init excepts only instance of StaticPage as param");
        }

        $qb = $this->db->getQueryBuilder()->from('seo')->where(array('page' => 'leptaden'));
        $pageData = $this->db->fetchRow( $qb );
        $this->_title = $pageData['meta_title'];
        $this->_description = $pageData['meta_description'];
        $this->_keywords = $pageData['meta_keywords'];
        $this->_robots = $pageData['meta_robots'];
    }
}