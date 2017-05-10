<?php

namespace ShopBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Order
 *
 * @ORM\Table(name="orders")
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\OrdersRepository")
 * @ORM\HasLifecycleCallbacks()
 *
 */
class Orders
{
    /**
     * @var string
     *
     * @ORM\Column(name="hash", type="string", length=255, nullable=false)
     */
    private $hash;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="decimal", precision=10, scale=5, nullable=false)
     */
    private $total;

    /**
     * @var integer
     *
     * @
     * @ORM\ManyToOne(targetEntity="ShopBundle\Entity\Addresses" , inversedBy="orders" ,cascade={"persist"})
     * @ORM\JoinColumn(name="address_id", referencedColumnName="id")
     * //@Assert\NotBlank()
     */
    private $addressId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="paid", type="boolean", nullable=false)
     *
     */
    private $paid;

    /**
     * @var integer
     *
     *
     * @ORM\ManyToOne(targetEntity="ShopBundle\Entity\Customers" , inversedBy="orders" , cascade={"persist"})
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     * //@Assert\NotBlank()
     */
    private $customerId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
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
     * //@Assert\NotBlank()
     */
    private $id;

    /**
     * @var Product[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="ShopBundle\Entity\OrdersProduct", mappedBy="orderId",  cascade={"persist", "remove"}, orphanRemoval=TRUE))
     *
     *
     *
     */
    private $products;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="ShopBundle\Entity\Payment", mappedBy="orderId")
     */


    private $payments;


    public function __construct($amount = 0)
    {
        $this->products = new ArrayCollection();
        $this->payments = new ArrayCollection();
        $this->total = $amount;
    }


    /**
     * @return ArrayCollection|Product[]
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param ArrayCollection|Product[] $products
     */
    public function setProducts($products)
    {
        $this->products = $products;
    }

    /**
     * @return ArrayCollection|Product[]
     */
    public function getPayments()
    {
        return $this->payments;
    }

    /**
     * @param ArrayCollection|Product[] $payments
     */
    public function setPayments($payments)
    {
        $this->payments = $payments;
    }


    /**
     * Set hash
     *
     * @param string $hash
     *
     * @return Orders
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Get hash
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Set total
     *
     * @param float $total
     *
     * @return Orders
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set addressId
     *
     * @param integer $addressId
     *
     * @return Orders
     */
    public function setAddressId($addressId)
    {
        $this->addressId = $addressId;

        return $this;
    }

    /**
     * Get addressId
     *
     * @return integer
     */
    public function getAddressId()
    {
        return $this->addressId;
    }

    /**
     * Set paid
     *
     * @param boolean $paid
     *
     * @return Orders
     */
    public function setPaid($paid)
    {
        $this->paid = $paid;

        return $this;
    }

    /**
     * Get paid
     *
     * @return boolean
     */
    public function getPaid()
    {
        return $this->paid;
    }

    /**
     * Set customerId
     *
     * @param integer $customerId
     *
     * @return Orders
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;

        return $this;
    }

    /**
     * Get customerId
     *
     * @return integer
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Orders
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
     * @return Orders
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
     * @ORM\PrePersist()
     */
    public function onPrePersist()
    {
        $this->createdAt = new \DateTime("now");
        $this->updatedAt = new \DateTime("now");
    }

    /**
     * Gets triggered every time on update
     * @ORM\PreUpdate()
     */
    public function onPreUpdate()
    {
        $this->updatedAt = new \DateTime("now");
    }


}
