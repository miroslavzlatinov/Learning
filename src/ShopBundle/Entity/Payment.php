<?php

namespace ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Payment
 *
 * @ORM\Table(name="payments")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 *
 */
class Payment
{
    /**
     * @ORM\ManyToOne(targetEntity="ShopBundle\Entity\Orders", inversedBy="payments")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     *
     *
     */
    private $orderId = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="failed", type="boolean", nullable=false)
     */
    private $failed = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="transaction_id", type="string", length=255, nullable=true)
     */
    private $transactionId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt = '0000-00-00 00:00:00';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt = '0000-00-00 00:00:00';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


    /**
     * Set orderId
     *
     * @param integer $orderId
     *
     * @return Payment
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * Get orderId
     *
     * @return integer
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Set failed
     *
     * @param boolean $failed
     *
     * @return Payment
     */
    public function setFailed($failed)
    {
        $this->failed = $failed;

        return $this;
    }

    /**
     * Get failed
     *
     * @return boolean
     */
    public function getFailed()
    {
        return $this->failed;
    }

    /**
     * Set transactionId
     *
     * @param string $transactionId
     *
     * @return Payment
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;

        return $this;
    }

    /**
     * Get transactionId
     *
     * @return string
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Payment
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
     * @return Payment
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
