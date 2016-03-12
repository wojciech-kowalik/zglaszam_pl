<?php
namespace Visualnet\MenuBundle\Extension;

use Visualnet\MenuBundle\Service;

/**
 * Menu twig extension
 * 
 * @author w.kowalik 
 * @package Visualnet\MenuBundle\Extension
 * @access public
 * @copyright visualnet.pl
 */
class Menu extends \Twig_Extension
{
    protected $menu;

    function __construct(Service\Menu $menu) {
        $this->menu = $menu;
    }

    public function getGlobals() {
        return array(
            'menu' => $this->menu
        );
    }

    public function getName()
    {
        return 'menu';
    }

}