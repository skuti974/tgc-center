<?php

namespace Tgc\Realm\Pokemon\Handler;

use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use TCGdex\Model\SerieResume;
use Tgc\Realm\Pokemon\Api\SerieApiInterface;
use Tgc\Realm\Pokemon\Message\SynchronizeSeriesMessage;
use Tgc\Realm\Pokemon\Message\SynchronizeSerieMessage;

#[AutoconfigureTag('messenger.message_handler')]
final readonly class SynchronizeSeriesHandler
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
    public function __invoke(SynchronizeSeriesMessage $message): void
    {
        /** @var SerieResume[]|null $response */
        $response = $this->api->all($message->locale());
        if (null === $response) {
            $this->logger->warning(sprintf('No Serie found from locale: %s', $message->locale()));
            return;
        }

        foreach ($response as $item) {
            $this->bus->dispatch(new SynchronizeSerieMessage(
                code: $item->id,
                name: $item->name,
                locale: $message->locale(),
            ));
        }
    }
}