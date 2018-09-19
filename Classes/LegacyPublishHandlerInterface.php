<?php

namespace SteveCohenFr\LegacyPublishHandlerBundle\Classes;


use eZ\Publish\API\Repository\Values\Content\Content;

interface LegacyPublishHandlerInterface
{

    /**
     * This function is called from legacy part before an object publication (called by workflow)
     * You must link the "before publish" trigger to the custom workflow
     *
     * @param Content          $content The legacy object
     * @param int              $version The object version
     *
     */
    function beforePublish(Content $content, $version);

    /**
     * This function is called from legacy part after an object publication (called by workflow)
     * You must link the "after publish" trigger to the custom workflow
     *
     * @param Content          $content The legacy object
     * @param int              $version The object version
     *
     */
    function afterPublish(Content $content, $version);

}