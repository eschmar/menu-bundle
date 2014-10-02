<?php

namespace Eschmar\MenuBundle\Menu;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

/**
 * Abstract class for creating menus
 *
 * @author Marcel Eschmann
 **/
abstract class AbstractMenu
{
    /**
     * @var SecurityContext
     **/
    protected $security;

    /**
     * @var Router
     **/
    protected $router;

    /**
     * @var MenuNode
     **/
    protected $root;

    /**
     * @var string
     **/
    protected $template = 'EschmarMenuBundle:Menu:default.html.twig';

    function __construct(SecurityContext $security, Router $router) {
        $this->security = $security;
        $this->router = $router;
        $this->generateMenu();
    }

    /**
     * Actual menu generation by inheriting classes
     *
     * @return void
     * @author Marcel Eschmann
     **/
    public abstract function generateMenu();

    /**
     * Adds a new node to the menu
     *
     * @return MenuNode
     * @author Marcel Eschmann
     **/
    public function newNode($title, $route = null, $role = null, array $attributes = array())
    {
        $path = $route === null ? '#' : $this->router->generate($route);
        return new MenuNode($this, $title, $role, $route, $path, $attributes);
    }

    /**
     * Returns the root node
     *
     * @return MenuNode
     * @author Marcel Eschmann
     **/
    public function getRoot()
    {
        if ($this->root->role !== null && !$this->security->isGranted($this->root->role)) {
            return null;
        }

        $this->parsePermissions($this->root);
        return $this->root;
    }

    /**
     * Recursively removes all nodes this user's lacking permissions for.
     *
     * @return void
     * @author Marcel Eschmann
     **/
    protected function parsePermissions(MenuNode $node)
    {
        foreach ($node->getChildren() as $key => $child) {
            if ($child->role === null || ($child->role !== null && $this->security->isGranted($child->role))) {
                $this->parsePermissions($child);
            }else {
                $node->offsetUnset($key);
            }
        }
    }

    /**
     * Defines which template is used to render the menu
     *
     * @return void
     * @author Marcel Eschmann
     **/
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    /**
     * Returns the template
     *
     * @return string
     * @author Marcel Eschmann
     **/
    public function getTemplate()
    {
        return $this->template;
    }

} // END abstract class AbstractMenu