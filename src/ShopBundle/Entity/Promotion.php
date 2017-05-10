<?php

namespace ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Promotion
 *
 * @ORM\Table(name="promotions")
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\PromotionRepository")
 */
class Promotion
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
     *
     *
     */

    private $name;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_from", type="datetime")
     * @Assert\NotBlank()
     *
     */
    private $dateFrom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_to", type="datetime")
     */
    private $dateTo;

    /**
     * @var string
     *
     * @ORM\Column(name="discount", type="decimal", precision=10, scale=2)
     * @Assert\NotBlank()
     *
     */
    private $discount;


    /**
     * @var Category
     * @ORM\ManyToOne(targetEntity="ShopBundle\Entity\Category", inversedBy="promotions")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id" , nullable=true)
     */

    private $category;
    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="ShopBundle\Entity\Product", inversedBy="promotions")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id" ,nullable=true)
     */

    private $product;

    /**
     *  @var string
     * @ORM\Column(name="userdefined", type="string", length=255)
     */


    private $userdefined;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }


    /**
     * @return Category|boolean
     */
    public function getCategory()
    {

            return $this->category;


    }

    /**
     * @param Category $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param Product $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
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
     * Set dateFrom
     *
     * @param \DateTime $dateFrom
     *
     * @return Promotion
     */
    public function setDateFrom($dateFrom)
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    /**
     * Get dateFrom
     *
     * @return \DateTime
     */
    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    /**
     * Get dateFrom
     *
     * @return string
     */
    public function getDateStart()
    {
        return $this->dateFrom->format('Y-m-d');
    }


    /**
     * Set dateTo
     *
     * @param \DateTime $dateTo
     *
     * @return Promotion
     */
    public function setDateTo($dateTo)
    {
        $this->dateTo = $dateTo;

        return $this;
    }

    /**
     * Get dateTo
     *
     * @return \DateTime
     */
    public function getDateTo()
    {
        return $this->dateTo;
    }

    /**
     * Get dateTo
     *
     * @return string
     */
    public function getDateEnd()
    {
        return $this->dateTo->format('Y-m-d');
    }

    /**
     * Set discount
     *
     * @param string $discount
     *
     * @return Promotion
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get discount
     *
     * @return string
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @return string
     *
     */

    function __toString()
    {
        $objectName = __Class__;
        $names = explode("\\", $objectName);
        $name = array_pop($names);
        return $name;
    }

    public function getRule()
    {

        $string = 'date(\'now\') >= date(\'' . $this->getDateStart() . '\') and date(\'now\') <= date(\'' . $this->getDateEnd() . '\') ? ' . ($this->discount / 100) . ' : 0';
        return $string;

    }


    //"date('now') >= date('2017-01-20') and date('now') <= date('2018-02-02') ? 0.05 : 0"

    /**
     * @return array
     *
     */

    public function getHeadCategory()
    {

        return ['name', 'dateStart', 'dateEnd', 'discount', ['category' => 'Name']];

    }

    public function getHeadProduct()
    {

        return ['name', 'dateStart', 'dateEnd', 'discount', ['product' => 'Name']];

    }


    public function getHeadUser()
    {

        return ['name', 'dateStart', 'dateEnd', 'discount', 'userdefined'];

    }

    /**
     * @return string
     */
    public function getUserdefined()
    {
        return $this->userdefined;
    }

    /**
     * @param string $userdefined
     */
    public function setUserdefined($userdefined)
    {
        $this->userdefined = $userdefined;
    }

}


