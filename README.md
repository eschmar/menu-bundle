# Eschmar Menu Bundle
Simple Object oriented menus for Symfony with role permissions.

# Installation
Composer (<a href="https://packagist.org/packages/eschmar/menu-bundle" target="_blank">Packagist</a>):
```sh
composer require eschmar/menu-bundle ~v0.2
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
        $this->root = $this->newNode('Navigation');

        // append a new node for each navigation element
        $this->root->node('Link 1');
        $this->root->node('Link 2');
        $this->root->node('Link 3');

        // multi-dimensional
        $this->root['Link 2']->node('Sublink 1');
        $this->root['Link 2']['Sublink 1']->node('Subsublink 1');

        // generate route
        $this->root['Link 3']->node('Sublink 3', null, 'acme_hello_homepage');

        // role permissions
        $this->root['Link 3']->node('Sublink 2', null, null, 'ROLE_ADMIN', array());
    }

} // END class TestMenu
````

Render the menu directly in twig:
````Twig
{{ menu('EschmarMenuBundle:Test') }}

{# override template #}
{{ menu('EschmarMenuBundle:Test', 'test/mobile.html.twig') }}
```

# License
MIT License.