<?php

namespace Eschmar\MenuBundle\Menu;

/**
 * Represents a single navigation element.
 *
 * @author Marcel Eschmann
 **/
class MenuNode implements \ArrayAccess, \Iterator
{
    /**
     * @var Menu
     **/
    protected $menu;

    /**
     * @var string
     **/
    public $title;

    /**
     * @var string
     **/
    public $role;

    /**
     * @var string
     **/
    public $route;

    /**
     * @var string
     **/
    public $path;

    /**
     * @var string
     **/
    public $prefix;

    /**
     * @var array
     **/
    public $attributes;

    /**
     * @var MenuNode
     **/
    protected $parent;

    /**
     * @var array(MenuNode)
     **/
    protected $children = array();

    function __construct($menu, $title, $role, $prefix, $route, $path, $attributes = array()) {
        $this->menu = $menu;
        $this->title = $title;
        $this->role = $role;
        $this->route = $route;
        $this->prefix = $prefix;
        $this->path = $path;
        $this->attributes = $attributes;
    }

    public function node($title, $prefix = null, $route = null, $role = null, array $attributes = array())
    {
        $node = $this->menu->newNode($title, $prefix, $route, $role, $attributes);

        if (!($node instanceof MenuNode)) {
            return null;
        }

        $node->setParent($this);
        $this->children[$node->title] = $node;
    }

    /**
     * Define node's parent node for backwards traversing.
     * Currently not in use.
     *
     * @return void
     * @author Marcel Eschmann
     **/
    protected function setParent(MenuNode $node)
    {
        $this->parent = $node;
    }

    /**
     * Check if this node has any children.
     *
     * @return boolean
     * @author Marcel Eschmann
     **/
    public function hasChildren()
    {
        return count($this->children) > 0 ? true : false;
    }

    /**
     * Return all children nodes in an array.
     *
     * @return array(MenuNode)
     * @author Marcel Eschmann
     **/
    public function getChildren()
    {
        return $this->children;
    }

    //
    //  ArrayAccess implementation
    //

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return isset($this->children[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->offsetExists($offset) ? $this->children[$offset] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset) && $value instanceof MenuNode) {
            $this->children[$value->title] = $value;
        } else {
            $this->children[$offset] = $value;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        unset($this->children[$offset]);
    }


    //
    //  Iterator implementation
    //

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        reset($this->children);
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return current($this->children);
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return key($this->children);
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        return next($this->children);
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return ($this->key() !== NULL && $this->key() !== FALSE);
    }

} // END class MenuNode