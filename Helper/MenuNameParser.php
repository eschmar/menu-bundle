<?php

namespace Eschmar\MenuBundle\Helper;

use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Parser class for logical menu names
 *
 * @package default
 * @author Marcel Eschmann
 **/
class MenuNameParser
{
    protected $bundleMap;

    function __construct(array $bundleMap) {
        $this->bundleMap = $bundleMap;
    }

    /**
     * Converts a logical menu name to a class name.
     *
     * @return string
     * @author Marcel Eschmann
     **/
    public function parse($menu)
    {
        if (2 != count($parts = explode(':', $menu))) {
            throw new \InvalidArgumentException(sprintf('The "%s" menu is not a valid "a:b" menu string.', $menu));
        }

        list($bundle, $menu) = $parts;
        if (!isset($this->bundleMap[$bundle])) {
            throw new \InvalidArgumentException(sprintf('Bundle "%s" does not exist or it is not enabled.', $bundle));
        }

        list($base) = explode($bundle, $this->bundleMap[$bundle]);
        $class = $base.'Menu\\'.$menu.'Menu';
        if (class_exists($class)) {
            return $class;
        }

        throw new \InvalidArgumentException(sprintf('Unable to find class %s.', $class));
    }

} // END class MenuNameParser