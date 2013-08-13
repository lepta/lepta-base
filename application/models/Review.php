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
use system\upload\Upload;

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

    public function setAvatar()
    {
        $config['upload_path'] = ROOT . '/userfiles/reviews/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']	= '1000';
        $config['max_width']  = '2024';
        $config['max_height']  = '1768';

        $upload = new Upload($config);

        if ( ! $upload->do_upload('avatar'))
        {
            /*
            $error = array('error' => $upload->display_errors());

            $this->load->view('upload_form', $error);
            */
        }
        else
        {
            $data = $upload->data();
            $this->img = $data['file_name'];
        }
    }
}