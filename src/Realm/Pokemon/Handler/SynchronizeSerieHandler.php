<?php

namespace Tgc\Realm\Pokemon\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Tgc\Realm\Pokemon\Entity\Serie;
use Tgc\Realm\Pokemon\Entity\SerieTranslation;
use Tgc\Realm\Pokemon\Message\SynchronizeSerieMessage;
use Tgc\Realm\Pokemon\Message\SynchronizeSetsMessage;
use Tgc\Realm\Pokemon\Repository\SerieRepository;

#[AutoconfigureTag('messenger.message_handler')]
readonly class SynchronizeSerieHandler
{
    public function __construct(
        private SerieRepository $repository,
        private EntityManagerInterface $entityManager,
        private MessageBusInterface $bus,
    ) {
    }

    /**
     * @throws ExceptionInterface
     */
    public function __invoke(SynchronizeSerieMessage $message): void
    {
        $serie = $this->repository->findOneBy(['code' => $message->code()]);
        if (null === $serie) {
            $serie = (new Serie())
                ->setCode($message->code());
        }

        $translation = $serie->localizedTranslation($message->locale());
        if (null === $translation) {
            $translation = (new SerieTranslation())
                ->setLocale($message->locale())
                ->setName($message->name());

            $this->entityManager->persist($translation);
            $serie->addTranslation($translation);
        }

        $this->entityManager->persist($serie);
        $this->entityManager->flush();

        $this->bus->dispatch(new SynchronizeSetsMessage(
            code: $message->code(),
            locale: $message->locale(),
        ));
    }
}