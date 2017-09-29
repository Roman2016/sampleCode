<?php

/**
 * Created by PhpStorm.
 * User: Users CS
 * Date: 23.09.2017
 * Time: 21:12
 */
namespace AppBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use AppBundle\Entity\Message;

class RegistrationCompletedListener implements EventSubscriberInterface
{
    private $router;
    private $em;
    private $message;

    public function __construct(UrlGeneratorInterface $router, EntityManager $em, Message $message)
    {
        $this->router = $router;
        $this->em = $em;
        $this->message = $message;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess',
        );
    }

    public function onRegistrationSuccess(FormEvent $event)
    {
        // This functionality can be implemented in external service
        $registrationForm = $event->getForm();
        $this->message->setContent('Welcome new user ' . $registrationForm->getData()->getUserName());
        $this->message->setAuthor($registrationForm->getData());
        $this->message->setDate(new \DateTime());
        $this->em->persist($this->message);
        $this->em->flush();

        $url = $this->router->generate('homepage');

        $event->setResponse(new RedirectResponse($url));
    }
}