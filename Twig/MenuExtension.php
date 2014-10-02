<?php

namespace Eschmar\MenuBundle\Twig;

use Eschmar\MenuBundle\Helper\MenuNameParser;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

/**
 * Twig Extension providing menu rendering functions
 *
 * @author Marcel Eschmann
 **/
class MenuExtension extends \Twig_Extension
{
    /**
     * @var MenuNameParser
     **/
    protected $parser;

    /**
     * @var SecurityContext
     **/
    protected $security;

    /**
     * @var Router
     **/
    protected $router;

    function __construct(MenuNameParser $parser, SecurityContext $security, Router $router) {
        $this->parser = $parser;
        $this->security = $security;
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'menu_extension';
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        $config = array(
            'needs_environment' => true,
            'is_safe' => array('html')
        );

        return array(
            new \Twig_SimpleFunction('menu', array($this, 'renderMenuFunction'), $config)
        );
    }

    /**
     * Menu to html renderer
     *
     * @return void
     * @author Marcel Eschmann
     **/
    public function renderMenuFunction(\Twig_Environment $twig, $name)
    {
        $class = $this->parser->parse($name);
        $menu = new $class($this->security, $this->router);
        $root = $menu->getRoot();
        return $twig->render($menu->getTemplate(), array('menu' => $root));
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('menuSlugify', array($this, 'menuSlugifyFilter'))
        );
    }

    /**
     * Simple slugifier for nav ids.
     *
     * @return string
     * @author Marcel Eschmann
     **/
    public function menuSlugifyFilter($input)
    {
        // remove all non-alphanumeric characters
        $result = preg_replace("/[^a-zA-Z0-9\-\_\.]/", '-', $input);

        // escape multiple consecutive seperators
        $result = preg_replace('/(-|_| )+/', '-', $result);

        // trim and convert to lower case
        return trim(strtolower($result));
    }

} // END class MenuExtension extends \Twig_Extension