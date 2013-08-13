<?php
namespace application\helpers;

/**
 * Class Menu
 * @package application\helpers
 */
class Menu
{
    /**
     * @param null $active
     * @return array
     */
    public static function getMainMenu($active = null)
    {
        $menu = array(
            'breast_milk' => array(
                'text' => 'Грудное молоко',
                'link' => '#breast_milk',
                'active' => false,
            ),
            'food' => array(
                'text' => 'Питание при кормлении',
                'link' => '#food',
                'active' => false
            ),
            'reduced_lactation' => array(
                'text' => 'Снижение лактации',
                'link' => '#reduced_lactation',
                'active' => false
            ),
            'improve_lactation' => array(
                'text' => 'Как улучшить лактацию?',
                'link' => '#improve_lactation',
                'active' => false
            ),
            'leptaden' => array(
                'text' => 'Лептаден',
                'link' => '#leptaden',
                'active' => false
            ),
            'reviews' => array(
                'text' => 'Отзывы',
                'link' => '#reviews',
                'active' => false
            ),
            'drugstores' => array(
                'text' => 'Аптеки',
                'link' => 'drugstores/',
                'class' => 'no-navigate',
                'active' => false
            ),
        );

        if (!is_null($active) && array_key_exists($active, $menu)) {
            $menu[$active]['active'] = true;
        }
        return array_values($menu);
    }
}