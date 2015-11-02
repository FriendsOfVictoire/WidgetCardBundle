Victoire DCMS Card Bundle
============

##What is the purpose of this bundle

This bundle gives you access to the *Card Widget*.
With this widget, you can integrate any Business Entity as a Card over any widget.

##Set Up Victoire

If you haven't already, you can follow the steps to set up Victoire *[here](https://github.com/Victoire/victoire/blob/master/setup.md)*

##Install the Bundle

Run the following composer command :

    php composer.phar require friendsofvictoire/card-widget

###Reminder

Declare the bundle in your AppKernel

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
