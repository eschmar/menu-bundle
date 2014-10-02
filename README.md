# Eschmar Menu Bundle
Simple Object oriented menus for Symfony 2 with role permissions.

# Installation
Composer (<a href="https://packagist.org/packages/eschmar/menu-bundle" target="_blank">Packagist</a>):
```json
"require": {
    "eschmar/menu-bundle": "dev-master"
},
```

app/Appkernel.php:
```php
new Eschmar\MenuBundle\EschmarMenuBundle(),
```

# Usage
Create a new ``<Name>Menu`` class extending the ``AbstractMenu`` for each of your menus:

````php
// src/Eschmar/MenuBundle/Menu/TestMenu.php
namespace Eschmar\MenuBundle\Menu;

class TestMenu extends AbstractMenu
{
    public function generateMenu()
    {
        // create root node
        $this->root = $this->newNode('Navigation', null, null, array());

        // append a new node for each navigation element
        $this->root->node('Link 1', null, null, array());
        $this->root->node('Link 2', null, null, array());
        $this->root->node('Link 3', null, null, array());

        // multi-dimensional
        $this->root['Link 2']->node('Sublink 1', null, null, array());
        $this->root['Link 2']['Sublink 1']->node('Subsublink 1', null, null, array());

        // role permissions
        $this->root['Link 3']->node('Sublink 2', null, 'ROLE_ADMIN', array());

        // generate route
        $this->root['Link 3']->node('Sublink 3', 'acme_hello_homepage', null, array());
    }

} // END class TestMenu
````

Render the menu directly in twig:
````Twig
{{ menu('EschmarMenuBundle:Test') }}
```

**Better introductions following soon!**

# License
MIT License.