<?php

namespace ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrdersProduct
 *
 * @ORM\Table(name="orders_products")
 * @ORM\Entity
 */
class OrdersProduct
{
    /**
     * @var integer
     *
     *
     * @ORM\ManyToOne(targetEntity="ShopBundle\Entity\Orders", inversedBy="products")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     */
    private $orderId;

    /**
     * @var integer
     *
     *
     * @ORM\ManyToOne(targetEntity="ShopBundle\Entity\Product", inversedBy="orders")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $productId;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity;

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
     * @return OrdersProduct
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
     * Set productId
     *
     * @param integer $productId
     *
     * @return OrdersProduct
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;

        return $this;
    }

    /**
     * Get productId
     *
     * @return integer
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return OrdersProduct
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
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
}
