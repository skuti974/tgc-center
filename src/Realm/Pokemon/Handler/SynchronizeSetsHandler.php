<?php

namespace Tgc\Realm\Pokemon\Handler;

use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use TCGdex\Model\SetResume;
use Tgc\Realm\Pokemon\Api\SerieApiInterface;
use Tgc\Realm\Pokemon\Message\SynchronizeSetMessage;
use Tgc\Realm\Pokemon\Message\SynchronizeSetsMessage;

#[AutoconfigureTag('messenger.message_handler')]
readonly class SynchronizeSetsHandler
{
    public function __construct(
        private SerieApiInterface $api,
        private MessageBusInterface $bus,
        private LoggerInterface $logger,
    ) {
    }

    /**
     * @throws ExceptionInterface
     */
    public function __invoke(SynchronizeSetsMessage $message): void
    {
        $serieApi = $this->api->findByCode($message->code(), $message->locale());
        if (null === $serieApi) {
            $this->logger->warning(sprintf('No Serie found with code "%s" and locale %s.', $message->code(), $message->locale()));
        }

        /** @var SetResume $set */
        foreach ($serieApi->sets as $set) {
            $this->bus->dispatch(new SynchronizeSetMessage(
                serieCode: $message->code(),
                code: $set->id,
                locale: $message->locale(),
            ));
        }
    }
}