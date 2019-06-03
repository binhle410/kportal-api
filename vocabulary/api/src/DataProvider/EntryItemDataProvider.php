<?php

declare(strict_types=1);

namespace App\DataProvider;


use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use App\Entity\Entry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

final class EntryItemDataProvider implements ItemDataProviderInterface
{
    private $manager;
    private $requestStack;

    public function __construct(EntityManagerInterface $manager, RequestStack $requestStack)
    {
        $this->manager = $manager;
        $this->requestStack = $requestStack;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])    {
        if (Entry::class !== $resourceClass) {
            throw new ResourceClassNotSupportedException();
        }

        $entryRepo = $this->manager->getRepository(Entry::class);
        $request = $this->requestStack->getCurrentRequest();

        // Retrieve the blog post item from somewhere then return it or null if not found
        if (empty($entry = $entryRepo->findOneBy(['uuid' => $entryUuid = $id]))) {
            $authHeaderCredentials = explode(' ', $request->headers->get('Authorization'));
            $jwtToken = array_pop($authHeaderCredentials);
            $entry = Entry::fetch($entryUuid, $jwtToken);
            $this->manager->persist($entry);
            $this->manager->flush($entry);

        }
        return $entry;
    }
}