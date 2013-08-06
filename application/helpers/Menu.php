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
            'templates' => array(
                'text' => 'Templates',
                'link' => Url::getCatalogUrl('powerpoint'),
                'active' => false,
            ),
            'features' => array(
                'text' => 'Features',
                'link' => Url::getStaticUrl('features'),
                'active' => false
            ),
            'contact-us' => array(
                'text' => 'Contact Us',
                'link' => Url::getFeedbackUrl(),
                'active' => false
            ),
            'profile' => array(
                'text' => 'Members',
                'link' => Url::getProfileUrl(),
                'active' => false
            )
        );

        if (!is_null($active) && array_key_exists($active, $menu)) {
            $menu[$active]['active'] = true;
        }
        return array_values($menu);
    }

    /**
     * @return array
     */
    public static function getHomeMenu()
    {
        $menu = self::getMainMenu();
        array_unshift($menu, array('text' => 'Home', 'link' => Url::getMainUrl(), 'active' => true));
        return $menu;
    }
}