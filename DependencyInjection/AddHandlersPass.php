<?php

namespace SteveCohenFr\LegacyPublishHandlerBundle\DependencyInjection;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class AddHandlersPass implements CompilerPassInterface
{

    /**
     * Get all providers based on their tag (`bazinga_geocoder.provider`) and
     * register them.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has("stevecohenfr.legacy.publish.handler")) {
            return;
        }
        $definition = $container->getDefinition("stevecohenfr.legacy.publish.handler");
        $taggedServices = $container->findTaggedServiceIds("stevecohenfr.legacy_publish_handler");

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addHandler', array(new Reference($id)));
        }
    }
}