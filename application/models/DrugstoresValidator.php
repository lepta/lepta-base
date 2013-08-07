<?php
namespace application\models;

/**
 * Class DrugstoresValidator
 * @package application\models
 */
class DrugstoresValidator extends Validator
{
    protected $_validationRules = array(
        'region' => array(
            'numeric',
            'value' => array(
                '>' => 0,
                '<' => 25
            )
        ),

        'city' => array(
            'numeric'
        )
    );
}