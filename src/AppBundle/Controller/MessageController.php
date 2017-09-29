<?php
/**
 * Created by PhpStorm.
 * User: Users CS
 * Date: 24.09.2017
 * Time: 14:15
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\MessageType;
use AppBundle\Entity\Message;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route as Route;

class MessageController extends Controller
{
    protected $message;
    protected $author;

    public function __construct(Message $message, User $user)
    {
        $this->message = $message;
        $this->author = $user;
    }

    /**
     * @Route("/addmessage", name="add_message")
     */
    public function AddMessageAction(Request $request)
    {
        if($this->getUser() == 'anon.')
        {
            $this->message->setAuthor($this->author);
        }
        else
        {
            $this->message->setAuthor($this->getUser());
        }
        $form = $this->createForm(MessageType::class, $this->message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $message = $form->getData();
            if(!$this->getUser())
            {
                $message->getAuthor()->setPassword('password');
                $message->getAuthor()->setPlainPassword('password');
                $message->getAuthor()->setEnabled(false);
                $message->getAuthor()->setLastLogin(new \DateTime());
            }
            $message->setDate(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('@App/message.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}