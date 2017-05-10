<?php

namespace ShopBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ProductType
 *
 * @ORM\Table(name="products")
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\ProductRepository")
 * @
 * @ORM\HasLifecycleCallbacks()
 *
 */
class Product
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="text")
     *
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=11, scale=2)
     * @Assert\NotBlank()
     */
    private $price;


    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $category;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="ShopBundle\Entity\User",inversedBy="products")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id")
     *
     */

    private $user;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="ShopBundle\Entity\Promotion", mappedBy="product")
     */
    private $promotions;

    /**
     * @var
     *
     *
     */

    private $promotionalPrice;


    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var integer
     *
     * @ORM\Column(name="stock", type="integer", nullable=false)
     */
    private $stock;

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
     * @var bool
     *
     * @ORM\Column(name="published" , type="boolean")
     *
     */

    private $published;


    /**
     * @var Orders[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="ShopBundle\Entity\OrdersProduct", mappedBy="productId")
     *
     *
     *
     */


    private $orders;

    /**
     * @Assert\Image(mimeTypes={"image/png", "image/jpeg"}, maxSize="5M")
     */
    private $image_form;


    private $offername;

    /**
     * @var array
     *
     * @ORM\Column(name="tags" , type="array" , nullable= TRUE)
     *
     */

    private $tags;

    /**
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }


    public function __construct()
    {
        $this->promotions = new ArrayCollection();
        $this->tags = new ArrayCollection();

    }

    /**
     * @return mixed
     */
    public function getPromotionalPrice()
    {


        return $this->promotionalPrice;
    }

    /**
     * @param $price
     * @var array
     */
    public function setPromotionalPrice($price)
    {
        if (is_array($price)) {
            $this->offername = key($price);

            $this->promotionalPrice = array_pop($price);

        }
    }


    public function getOffername()
    {
        return $this->offername;
    }

    /**
     * @return ArrayCollection
     */
    public function getPromotions()
    {
        return $this->promotions;
    }

    /**
     * @param ArrayCollection $promotions
     */
    public function setPromotions($promotions)
    {
        $this->promotions = $promotions;
    }


    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }


    /**
     * Get category
     * @return string
     */
    public function getCategory()
    {
        return $this->category;

    }

    /**
     * @param string $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Product
     *
     *
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
     *
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
     *
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Product
     * @
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }


    function __toString()
    {
        $objectName = __Class__;
        $names = explode("\\", $objectName);
        $name = array_pop($names);
        return $name;
    }


    public function getProduct()
    {

        return $this->getName();
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Product
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set stock
     *
     * @param integer $stock
     *
     * @return Product
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return integer
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @return mixed
     */
    public function getImageForm()
    {
        return $this->image_form;
    }

    /**
     * @param mixed $image_form
     */
    public function setImageForm($image_form)
    {
        $this->image_form = $image_form;
    }


    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Product
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
        return $this->createdAt->format('Y-m-d');
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Product
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
        return $this->updatedAt->format('Y-m-d');
    }


    /**
     * @return bool
     */
    public function isPublished()
    {
        return $this->published;
    }

    /**
     * @return bool
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * @param bool $published
     */
    public function setPublished($published)
    {
        $this->published = $published;
    }

    public function hasLowStock()
    {
        if ($this->outOfStock()) {
            return false;
        }
        return (bool)($this->stock <= 5);
    }

    public function outOfStock()
    {
        return $this->stock === 0;
    }

    public function inStock()
    {
        return $this->stock >= 1;
    }

    public function hasStock($quantity)
    {
        return $this->stock >= $quantity;
    }

    /**
     * @return ArrayCollection|Orders[]
     *
     */

    public function order()
    {
        return $this->orders;

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


    /**
     * @return array
     *
     */

    public function getHead()
    {

        return ['name', 'price', 'stock', "updatedAt", "createdAt", ['category' => 'Name'], 'published',];

    }


}

