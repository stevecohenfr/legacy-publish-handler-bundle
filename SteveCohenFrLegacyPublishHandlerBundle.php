<?php

namespace SteveCohenFr\LegacyPublishHandlerBundle;

use SteveCohenFr\LegacyPublishHandlerBundle\DependencyInjection\AddHandlersPass;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SteveCohenFrLegacyPublishHandlerBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AddHandlersPass());
    }
}