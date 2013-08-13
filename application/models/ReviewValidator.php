<?php
namespace application\models;


class ReviewValidator extends Validator
{
    protected $_validationRules = array(
        'would_recommend' => array(
            'value' => array(
                'range' => array('Y', 'N')
            )
        ),
        'author_name' => array('not_empty'),
        'problem_description' => array('not_empty'),
        'problem_solution' => array('not_empty'),
        'captcha' => array('not_empty')
    );
}