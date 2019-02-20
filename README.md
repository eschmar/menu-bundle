# Eschmar Menu Bundle
Simple Object oriented menus for Symfony with role permissions.

# Installation
Composer (<a href="https://packagist.org/packages/eschmar/menu-bundle" target="_blank">Packagist</a>):
```sh
composer require eschmar/menu-bundle ^1.0.0 # Symfony 4
```

See `eschmar/menu-bundle ^0.2.0` for Symfony 3.

# Usage
Create a new ``<Name>Menu`` class extending the ``AbstractMenu`` for each of your menus in your `App\Menu` namespace:

````php
namespace App\Menu;

use Eschmar\MenuBundle\Menu\AbstractMenu;

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
{{ menu('TestMenu') }}

{# override template #}
{{ menu('TestMenu', 'test/mobile.html.twig') }}
```

# License
MIT License.
