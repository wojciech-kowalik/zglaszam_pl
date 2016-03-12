<?php

namespace Visualnet\MenuBundle\Service;

use Visualnet\MenuBundle\Model;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Visualnet\VisualRecruiter\UtilsBundle\Service\Common;
use Symfony\Component\HttpFoundation\Session;

/**
 * Menu service
 * 
 * @author w.kowalik 
 * @package Visualnet\MenuBundle\Service
 * @access public
 * @copyright visualnet.pl
 */
class Menu
{

    protected $session;
    
    protected $utils;

    public function __construct(Session $session, Common $utils)
    {
        $this->session = $session;
        $this->utils = $utils;
    }

    /**
     * Add I18n objects into menu
     * 
     * @param Model\Menu $menu
     * @param ContainerInterface $container 
     */
    public function addTranslate(Model\Menu $menu, ContainerInterface $container)
    {
        $langs = $container->getParameter('langs');

        if (!empty($langs)) {

            foreach ($langs as $lang) {

                $translate = new Model\MenuI18n();
                $translate->setLocale($container->get("utils")->getRegionLocale($lang));
                $menu->addMenuI18n($translate);
            }
        }
    }

    /**
     * Get menu elements (use in controller and twig view thats why dont implement ContainerInterface)
     * 
     * @param boolean $showNoActive
     * @return PropelCollection 
     */
    public function get($showNoActive = false)
    {
        $regionLocale = $this->utils->getRegionLocale($this->session->getLocale());
        return Model\MenuQuery::create()->getItems($regionLocale, $showNoActive)->find();
    }

}
