<?php

class SmilePublishType extends eZWorkflowEventType
{
    const WORKFLOW_TYPE_STRING = "smilepublish";

    public function __construct()
    {
        parent::__construct( SmilePublishType::WORKFLOW_TYPE_STRING, 'Smile Publish Handler' );
    }

    public function execute($process, $event)
    {
        eZDebug::writeDebug('Executing' . __METHOD__);
        $parameters = $process->attribute('parameter_list');
        $serviceContainer = ezpKernel::instance()->getServiceContainer();
        $legacyObjectHandler = $serviceContainer->get('smile.legacy.publish.handler');

        switch ($parameters["trigger_name"]) {
            case "pre_publish":
                $object = eZContentObject::fetch($parameters['object_id']);
                $objectVersion = $parameters['version'];
                $legacyObjectHandler->beforePublish($object, $objectVersion);
            break;
            case "post_publish":
                $object = eZContentObject::fetch($parameters['object_id']);
                $objectVersion = $parameters['version'];
                $legacyObjectHandler->afterPublish($object, $objectVersion);
                break;
        }
        return eZWorkflowType::STATUS_ACCEPTED;
    }
}
eZWorkflowEventType::registerEventType( SmilePublishType::WORKFLOW_TYPE_STRING, 'smilepublishtype' );