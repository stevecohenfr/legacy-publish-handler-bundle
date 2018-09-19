# LegacyPublishHandlerBundle
Bundle to handle content pre/post publish from LegacyBridge to Symfony

Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash

    $ composer require stevecohenfr/legacy-publish-handler-bundle:"*"
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md) of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles
in the ``app/AppKernel.php`` file of your project:

```php

    <?php
    // app/AppKernel.php

    // ...
    class AppKernel extends Kernel
    {
        public function registerBundles()
        {
            $bundles = array(
                // ...

                new SteveCohenFr\LegacyPublishHandlerBundle\SteveCohenFrLegacyPublishHandlerBundle(),
            );

            // ...
        }

        // ...
    }
```

Deploy the legacy extension:
```bash
php bin/console ezpublish:legacybundles:install_extensions --relative
```

And clear the cache:
```bash
php bin/console cache:clear
```

Step 3: Create the workflow and trigger it
------------------------------------------

- Go to Administration -> Workflows
- Create a new workflow group or use "Standard"
- Create a new Workflow process and name it as you want
- In the dropdown choose "Legacy Publish Handler
- Save
- Go to Administration -> Triggers
- At the line "content publish after" or "content publish before", use the dropdown to choose your previously created Worlflow

Step 4: Handle the publish event
--------------------------------

This handler use the tag 'legacy.publish_handler' :

`service.yml`
```yml
services:
    on_publish_handler:
        class: ACME\ACMEBundle\Handlers\OnPublishHandler
        tags:
            - { name: stevecohenfr.legacy_publish_handler }
```

`ACME\ACMEBundle\Handlers\OnPublishHandler.php`
```php
namespace ACME\ACMEBundle\Handlers;

use eZ\Publish\API\Repository\Values\Content\Content;
use SteveCohenFr\LegacyPublishHandlerBundle\Classes\LegacyPublishHandlerInterface;

class OnPublishHandler implements LegacyPublishHandlerInterface
{
    /**
     * This function is called from legacy part before an object publication (called by workflow)
     * You must link the "before publish" trigger to the custom workflow
     *
     * @param Content $content              The legacy object
     * @param int     $version              The object version
     *
     */
    function beforePublish(Content $content, $version)
    {
        //TODO this function will be called before the content is published
    }

    /**
     * This function is called from legacy part after an object publication (called by workflow)
     * You must link the "after publish" trigger to the custom workflow
     *
     * @param Content $content              The legacy object
     * @param int     $version              The object version
     *
     */
    function afterPublish(Content $content, $version)
    {
       //TODO this function will be called after the content is published
    }
}
```
