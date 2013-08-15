<?php
namespace application\models\seo;


use application\models\Drugstores;
use application\models\Seo;

class SeoDrugstores extends Seo
{
    protected $_table = 'seo';

    public function init($page)
    {
        if (!($page instanceof Drugstores )) {
            throw new WrongInputParamsException("SeoStatic::init excepts only instance of StaticPage as param");
        }

        $qb = $this->db->getQueryBuilder()->from('seo')->where(array('page' => 'drugstores'));
        $pageData = $this->db->fetchRow( $qb );
        $this->_title = $pageData['meta_title'];
        $this->_description = $pageData['meta_description'];
        $this->_keywords = $pageData['meta_keywords'];
        $this->_robots = $pageData['meta_robots'];
    }
}