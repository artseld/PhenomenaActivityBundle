Installation
============

Currently this bundle depends on [RabbitMqBundle](https://github.com/videlalvaro/RabbitMqBundle) by Videl Alvaro and [SonataEasyExtendsBundle](https://github.com/sonata-project/SonataEasyExtendsBundle) by Sonata-project.

Installing dependencies
-----------------

To begin, all dependent bundles\libraries should be installed and enabled. For details see [RabbitMQBundle](https://github.com/videlalvaro/RabbitMqBundle/blob/master/README.md) and [SonataEasyExtends](http://sonata-project.org/bundles/easy-extends/master/doc/reference/installation.html) installation manuals

Installing bundle
-----------------

Similar to bundles you previously installed you should include this bundle to ``deps`` file:

    [PhenomenaActivityBundle]
        git=git://github.com/pluff/PhenomenaActivityBundle.git
        target=bundles/Phenomena/ActivityBundle

and install the bundle by running::

    bin/vendors install
    
Next, you must complete the new namespaces registration in the ``autoload.php`` config

```
  <?php
  $loader->registerNamespaces(array(
      ...
      'Application'   => __DIR__.'/../src',
      'Phenomena'     => __DIR__.'/../vendor/bundles'
      ...
  ));
```

Next, be sure to enable the new bundles in your application kernel:

```
  <?php
  // app/appkernel.php
  public function registerBundles()
  {
      return array(
          // ...
          new Phenomena\ActivityBundle\PhenomenaActivityBundle(),
          // ...
      );
  }
```

This bundle uses SonataEasyExtends method to extend bundles, so you need to generate the correct entities for the bundle:

```
    php app/console sonata:easy-extends:generate PhenomenaActivityBundle
```

Now, you can build up your database:

```
    app/console doctrine:schema:[create|update]
```


At this point the bundle is installed and ready to be used, however you still can't do anything useful with it.


Writing your first activity
---------------------------

TODO