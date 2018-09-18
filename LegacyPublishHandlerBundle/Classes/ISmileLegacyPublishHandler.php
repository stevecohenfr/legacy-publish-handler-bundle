<?php

namespace Smile\LegacyPublishHandlerBundle\Classes;


use eZ\Publish\API\Repository\Values\Content\Content;

interface ISmileLegacyPublishHandler
{

    /**
     * This function is called from legacy part before an object publication (called by workflow)
     *
     * @param Content          $content              The legacy object
     * @param String           $contentObjectVersion The object version
     *
     */
    function beforePublish(Content $content, $contentObjectVersion);

    /**
     * This function is called from legacy part after an object publication (called by workflow)
     * You need to link the afterPublish trigger to the custom workflow
     *
     * @param Content          $content              The legacy object
     * @param String           $contentObjectVersion The object version
     *
     */
    function afterPublish(Content $content, $contentObjectVersion);

}