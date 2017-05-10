<?php

namespace ShopBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Category
 *
 * @ORM\Table(name="categories")
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\CategoryRepository")
 */
class Category
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
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="print_num", type="integer", unique=true)
     * @Assert\NotBlank()
     */
    private $printNum;


    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="category")
     */
    private $products;
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="ShopBundle\Entity\Promotion", mappedBy="category")
     */

    private $promotions;

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


    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param ArrayCollection $products
     *
     */
    public function setProducts($products)
    {
        $this->products = $products;
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
     * @return Category
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
     * @return string
     *
     */

    public function getCategory()

    {
        return $this->name;

    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Category
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
     * Set printNum
     *
     * @param integer $printNum
     *
     * @return Category
     */
    public function setPrintNum($printNum)
    {
        $this->printNum = $printNum;

        return $this;
    }

    /**
     * Get printNum
     *
     * @return int
     */
    public function getPrintNum()
    {
        return $this->printNum;
    }


    function __toString()
    {
        $objectName = __Class__;
        $names = explode("\\", $objectName);
        $name = array_pop($names);
        return $name;
    }

    public function getHead()
    {

        return ['name', 'description', 'printNum'];

    }

}

