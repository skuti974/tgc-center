<?php

namespace Tgc\Realm\Pokemon\Handler;

use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Tgc\Realm\Pokemon\Api\SetApiInterface;
use Tgc\Realm\Pokemon\Entity\Set;
use Tgc\Realm\Pokemon\Entity\SetCardCount;
use Tgc\Realm\Pokemon\Entity\SetTranslation;
use Tgc\Realm\Pokemon\Message\SynchronizeSetMessage;
use Tgc\Realm\Pokemon\Repository\SerieRepository;
use Tgc\Realm\Pokemon\Repository\SetRepository;

#[AutoconfigureTag('messenger.message_handler')]
readonly class SynchronizeSetHandler
{
    public function __construct(
        private SetApiInterface $api,
        private SerieRepository $serieRepository,
        private SetRepository $setRepository,
        private EntityManagerInterface $entityManager,
        private MessageBusInterface $bus,
        private LoggerInterface $logger,
    ) {
    }

    /**
     * @throws ExceptionInterface
     */
    public function __invoke(SynchronizeSetMessage $message): void
    {
        $serie = $this->serieRepository->findOneByCodeAndLocale(
            code: $message->serieCode(),
            locale: $message->locale(),
        );

        if (null === $serie) {
            $this->logger->warning(sprintf('No Serie found for code %s and locale %s', $message->serieCode(), $message->locale()));
            return;
        }

        $setApi = $this->api->findByCode($message->code(), $message->locale());
        if (null === $setApi) {
            $this->logger->warning(sprintf('No Set found for code %s and locale %s', $message->code(), $message->locale()));
            return;
        }

        $set = $this->setRepository->findOneByCodeAndLocale($message->code(), $message->locale());
        if (null === $set) {
            $setCardCount = (new SetCardCount())
                ->setNormal($setApi->cardCount->normal)
                ->setFirstEdition($setApi->cardCount->firstEd)
                ->setHolo($setApi->cardCount->holo)
                ->setReverse($setApi->cardCount->reverse)
                ->setOfficial($setApi->cardCount->official)
                ->setTotal($setApi->cardCount->total)
            ;

            $this->entityManager->persist($setCardCount);

            $set = (new Set())
                ->setCode($setApi->id)
                ->setReleasedAt(new DateTimeImmutable($setApi->releaseDate))
                ->setSetCardCount($setCardCount)
            ;
        }

        $translation = $set->localizedTranslation($message->locale());
        if (null === $translation) {
            $translation = (new SetTranslation())
                ->setLocale($message->locale())
                ->setName($setApi->name);

            $this->entityManager->persist($translation);
            $set->addTranslation($translation);
        }

        $this->entityManager->persist($set);
        $this->entityManager->flush();
    }
}