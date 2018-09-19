# SmileLegacyPublishHandlerBundle
Bundle to handle content pre/post publish from LegacyBridge to Symfony

## Install

Clone the bundle
```bash
cd src/
mkdir Smile
cd Smile/
git clone git@github.com:stevecohenfr/SmileLegacyPublishHandlerBundle.git LegacyPublishHandlerBundle
```

Add it to the `AppKernel.php`
```php
$bundles = [
   [...],
   new Smile\LegacyPublishHandlerBundle\SmileLegacyPublishHandlerBundle(),
```

Clear cache:
```bash
php bin/console cache:clear --env=dev
```

## Install the legacy extension

```bash
php bin/console ezpublish:legacy:assets_install --relative --symlink web
```

## Create the workflow and trigger it

- Go to Administration -> Workflows
- Create a new workflow group or use "Standard"
- Create a new Workflow process and name it as you want
- In the dropdown choose "Smile Publish Handler
- Save
- Go to Administration -> Triggers
- At the line "content publish after" or "content publish before", use the dropdown to choose your previously created Worlflow

## Handle the publish event

This handler use the tag 'smile.legacy_publish_handler' :

`service.yml`
```yml
services:
    on_publish_handler:
        class: ACME\ACMEBundle\Handlers\OnPublishHandler
        tags: ['smile.legacy_publish_handler']
```

`ACME\ACMEBundle\Handlers\OnPublishHandler.php`
```php
namespace ACME\ACMEBundle\Handlers;

use eZ\Publish\API\Repository\Values\Content\Content;
use Smile\LegacyPublishHandlerBundle\Classes\SmileLegacyPublishHandlerInterface;

class OnPublishHandler implements SmileLegacyPublishHandlerInterface
{
    /**
     * This function is called from legacy part before an object publication (called by workflow)
     *
     * @param Content $content              The legacy object
     * @param String  $contentObjectVersion The object version
     *
     */
    function beforePublish(Content $content, $contentObjectVersion)
    {
    }

    /**
     * This function is called from legacy part after an object publication (called by workflow)
     * You need to link the afterPublish trigger to the custom workflow
     *
     * @param Content $content              The legacy object
     * @param String  $contentObjectVersion The object version
     *
     */
    function afterPublish(Content $content, $contentObjectVersion)
    {
       //TODO your code here
    }
}
```
