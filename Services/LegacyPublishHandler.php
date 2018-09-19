<?php

namespace SteveCohenFr\LegacyPublishHandlerBundle\Services;

use eZ\Publish\API\Repository\Values\Content\Content;
use eZ\Publish\Core\SignalSlot\Repository;
use SteveCohenFr\LegacyPublishHandlerBundle\Classes\LegacyPublishHandlerInterface;

class LegacyPublishHandler
{

    private $contentService;

    private $handlers;

    public function __construct(Repository $repository)
    {
        $this->contentService = $repository->getContentService();
        $this->handlers = array();
    }

    public function addHandler(LegacyPublishHandlerInterface $handler)
    {
        $this->handlers[] = $handler;
    }

    /**
     * This function is called from legacy part before an object publication (called by editHandler)
     *
     * @param \eZContentObject $object               The legacy object
     * @param String           $contentObjectVersion The object version
     *
     * @throws \eZ\Publish\API\Repository\Exceptions\NotFoundException
     * @throws \eZ\Publish\API\Repository\Exceptions\UnauthorizedException
     */
    function beforePublish(\eZContentObject $object, $contentObjectVersion)
    {
        $content = $this->legacyObjectToContent($object);
        /** @var LegacyPublishHandlerInterface $handler */
        foreach ($this->handlers as $handler) {
            $handler->beforePublish($content, (int)$contentObjectVersion);
        }
    }

    /**
     * This function is called from legacy part after an object publication (called by workflow)
     * You need to link the afterPublish trigger to the custom workflow
     *
     * @param \eZContentObject $object               The legacy object
     * @param String           $contentObjectVersion The object version
     *
     * @throws \eZ\Publish\API\Repository\Exceptions\NotFoundException
     * @throws \eZ\Publish\API\Repository\Exceptions\UnauthorizedException
     */
    function afterPublish(\eZContentObject $object, $contentObjectVersion)
    {
        $content = $this->legacyObjectToContent($object);
        /** @var LegacyPublishHandlerInterface $handler */
        foreach ($this->handlers as $handler) {
            $handler->afterPublish($content, (int)$contentObjectVersion);
        }
    }

    /**
     * Convert a legacy object to symfony content
     *
     * @param \eZContentObject $object The legacy object to convert
     *
     * @return Content
     * @throws \eZ\Publish\API\Repository\Exceptions\NotFoundException
     * @throws \eZ\Publish\API\Repository\Exceptions\UnauthorizedException
     */
    private function legacyObjectToContent(\eZContentObject $object)
    {
        $content = $this->contentService->loadContent($object->ID);

        return $content;
    }
}