<?php
/**
 * Created by PhpStorm.
 * User: Users CS
 * Date: 23.09.2017
 * Time: 21:38
 */

namespace AppBundle\Entity;

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MessageRepository")
 */
class Message
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 1,
     *      max = 1000,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="id", cascade={"persist"})
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id", nullable=true)
     */
    private $author;

//    /**
//    * @ORM\ManyToOne(targetEntity="AnonimousUser", inversedBy="id", cascade={"persist"})
//    * @ORM\JoinColumn(name="anonimous_author_id", referencedColumnName="id", nullable=true)
//    */
//    private $anonimousAuthor;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Message
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Message
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set author
     *
     * @param \AppBundle\Entity\User $author
     *
     * @return Message
     */
    public function setAuthor(\AppBundle\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \AppBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

//    /**
//     * Set anonimousAuthor
//     *
//     * @param \AppBundle\Entity\AnonimousUser $anonimousAuthor
//     *
//     * @return Message
//     */
//    public function setAnonimousAuthor(\AppBundle\Entity\AnonimousUser $anonimousAuthor = null)
//    {
//        $this->anonimousAuthor = $anonimousAuthor;
//
//        return $this;
//    }
//
//    /**
//     * Get anonimousAuthor
//     *
//     * @return \AppBundle\Entity\AnonimousUser
//     */
//    public function getAnonimousAuthor()
//    {
//        return $this->anonimousAuthor;
//    }
}
