Victoire CMS Card Bundle 
============

Need to add a card in a victoire website ?

First you need to have a valid Symfony2 Victoire edition.
Then run:

```
    php composer.phar require friendsofvictoire/card-widget
```

Declare the bundle in your AppKernel

```php
    class AppKernel extends Kernel
    {
        public function registerBundles()
        {
            $bundles = array(
                ...
                new Victoire\Widget\CardBundle\VictoireWidgetCardBundle(),
            );

            return $bundles;
        }
    }
```
