<?php

/**
 * Created by PhpStorm.
 * User: roman
 * Date: 22.09.17
 * Time: 15:57
 */
namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="app_users")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\OneToMany(targetEntity="Message", mappedBy="author")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
