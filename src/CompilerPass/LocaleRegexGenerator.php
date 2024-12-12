<?php

declare(strict_types=1);

namespace Tgc\CompilerPass;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class LocaleRegexGenerator implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if ($container->hasParameter('kernel.enabled_locales')) {
            $locales = $container->getParameter('kernel.enabled_locales');
            if (is_array($locales)) {
                $regex = implode('|', $locales);
                $container->setParameter('locales_regex', $regex);
            }
        }
    }
}
