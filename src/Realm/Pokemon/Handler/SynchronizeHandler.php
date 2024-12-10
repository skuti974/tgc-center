<?php

namespace Tgc\Realm\Pokemon\Handler;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use TCGdex\Model\SerieResume;
use Tgc\Realm\Pokemon\Api\SerieApiInterface;
use Tgc\Realm\Pokemon\Message\SynchronizeMessage;
use Tgc\Realm\Pokemon\Message\SynchronizeSerieMessage;

#[AutoconfigureTag('messenger.message_handler')]
final readonly class SynchronizeHandler
{
    public function __construct(
        private SerieApiInterface $api,
        private MessageBusInterface $bus,
    ) {
    }

    /**
     * @throws ExceptionInterface
     */
    public function __invoke(SynchronizeMessage $message): void
    {
        /** @var SerieResume[] $response */
        $response = $this->api->all($message->locale());
        foreach ($response as $item) {
            $this->bus->dispatch(new SynchronizeSerieMessage(
                code: $item->id,
                name: $item->name,
                locale: $message->locale(),
            ));
        }
    }
}