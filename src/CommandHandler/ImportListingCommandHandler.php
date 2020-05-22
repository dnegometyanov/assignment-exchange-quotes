<?php

namespace App\CommandHandler;

use App\Command\ImportListingCommand;
use App\Entity\Listing;
use App\Repository\ListingRepository;
use Doctrine\ORM\EntityManagerInterface;

class ImportListingCommandHandler
{
    // TODO inject from .env
    const DATA_SOURCE_URL = 'https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json';

    /**
     * @var ListingRepository
     */
    private ListingRepository $listingRepository;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    public function __construct(
        ListingRepository $listingRepository,
        EntityManagerInterface $em
    )
    {
        $this->listingRepository = $listingRepository;
        $this->em                = $em;
    }

    public function handle(ImportListingCommand $command)
    {
        $jsonContent = file_get_contents(self::DATA_SOURCE_URL);
        $listingData = \json_decode($jsonContent, true);

        foreach ($listingData as $item) {
            $listing = $this->listingRepository->findOneBySymbol($item['Symbol']);

            if ($listing) {
                $listing->update(
                    $item['Symbol'],
                    $item['Company Name'],
                );
            } else {
                $listing = new Listing(
                    $item['Symbol'],
                    $item['Company Name'],
                );

                $this->em->persist($listing);
            }
        }

        $this->em->flush();
    }
}