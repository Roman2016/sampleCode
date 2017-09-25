<?php
/**
 * Created by PhpStorm.
 * User: Users CS
 * Date: 24.09.2017
 * Time: 14:15
 */

namespace AppBundle\Controller;

use AppBundle\Entity\AnonimousUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\MessageType;
use AppBundle\Entity\Message;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route as Route;

class MessageController extends Controller
{
    protected $message;
    protected $anonimousAuthor;

    public function __construct(Message $message, AnonimousUser $anonimousUser)
    {
        $this->message = $message;
        $this->anonimousAuthor = $anonimousUser;
    }

    /**
     * @Route("/addmessage", name="add_message")
     */
    public function AddMessageAction(Request $request)
    {
        if($this->getUser() == 'anon.')
        {
            $this->message->setAnonimousAuthor($this->anonimousAuthor);
        }
        $form = $this->createForm(MessageType::class, $this->message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $message = $form->getData();
            $message->setDate(new \DateTime());
            $message->setAuthor($this->getUser());

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