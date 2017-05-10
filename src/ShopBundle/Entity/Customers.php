<?php

namespace ShopBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Customers
 *
 * @ORM\Table(name="customers")
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\CustomersRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Customers
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=90, nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="3")
     *
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=70, nullable=false)
     * @Assert\Email()
     * @Assert\NotBlank()
     *
     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var
     *
     * @ORM\OneToMany(targetEntity="ShopBundle\Entity\Orders",mappedBy="customerId")
     *
     */

    private $orders;

    /**
     * @ORM\ManyToOne(targetEntity="ShopBundle\Entity\User", inversedBy="customers")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     */

    private $user;

   public function  __construct()
   {
       $this->orders = new ArrayCollection();
   }

    /**
     * @return Orders|ArrayCollection
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * @param Orders|ArrayCollection $orders
     */
    public function setOrders($orders)
    {
        $this->orders = $orders;
    }


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Customers
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Customers
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Customers
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Customers
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

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
     * Gets triggered only on insert

     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->createdAt = new \DateTime("now");
        $this->updatedAt = new \DateTime("now");
    }

    /**
     * Gets triggered every time on update

     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updatedAt = new \DateTime("now");
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
}
