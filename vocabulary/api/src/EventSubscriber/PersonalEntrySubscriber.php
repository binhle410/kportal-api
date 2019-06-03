<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Entry;
use App\Entity\IndividualMember;
use App\Entity\Person;
use App\Entity\PersonalEntry;
use App\Security\JWTUser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class PersonalEntrySubscriber implements EventSubscriberInterface
{
    private $registry;
    private $mailer;
    private $security;

    public function __construct(EntityManagerInterface $manager, RegistryInterface $registry, \Swift_Mailer $mailer, Security $security)
    {
        $this->manager = $manager;
        $this->registry = $registry;
        $this->mailer = $mailer;
        $this->security = $security;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['onKernelView', EventPriorities::PRE_WRITE],
//            KernelEvents::REQUEST => ['onKernelRequest', EventPriorities::PRE_DESERIALIZE]
        ];
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            // don't do anything if it's not the master request
            return;
        }
//        $event->get
    }

    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        /** @var PersonalEntry $pEntry */
        $pEntry = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$pEntry instanceof PersonalEntry || Request::METHOD_POST !== $method) {
            return;
        }

        /** @var JWTUser $user */
        $user = $this->security->getUser();
        if (empty($user) or empty($personUuid = $user->getPersonUuid())) {
            $event->setResponse(new JsonResponse(['Unauthorised access! Empty user'], 401));
        }

        $personRepo = $this->registry->getRepository(Person::class);
        $entryRepo = $this->registry->getRepository(Entry::class);

        if (empty($entryRepo->findOneBy(['uuid' => $entryUuid = $pEntry->getEntry()->getUuid()]))) {
            $authHeaderCredentials = explode(' ', $event->getRequest()->headers->get('Authorization'));
            $jwtToken = array_pop($authHeaderCredentials);
            $entry = Entry::fetch($entryUuid, $jwtToken);
            $this->manager->persist($entry);
            $this->manager->flush($entry);
            $pEntry->setEntry($entry);
        }

        /** @var Person $person */
        $person = $personRepo->findOneBy(['uuid' => $personUuid,
        ]);
//        $event->setResponse(new JsonResponse(['hello'=>'im','im'=>$im], 200));

        $pEntry->setPerson($person);

//        $event->setControllerResult($pEntry);

//        throw new InvalidArgumentException('hello');

//        $event->setResponse(new JsonResponse(['attendee'=>$attendee->getRegistration()->getFamilyName(), 'user' => [
//            'im' => $user->getImUuid(),
//            'username' => $user->getUsername(), 'org' => $user->getOrgUuid()]], 200));
    }
}
