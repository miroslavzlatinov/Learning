<?php

namespace ShopBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\UserRepository")
 */
class User implements UserInterface
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
     * @ORM\Column(name="username", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min="4")
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(max="5",minMessage="Your Paasurd must be at least 5 digits")
     */
    private $password;

    /**
     * @var Role[]|ArrayCollection()
     *
     * @ORM\ManyToMany(targetEntity="ShopBundle\Entity\Role",inversedBy="users")
     * @ORM\JoinTable(name="user_roles",
     *     joinColumns={
     *     @ORM\JoinColumn(name="user_id",referencedColumnName="id")},
     *     inverseJoinColumns={
     *     @ORM\JoinColumn(name="role_id",referencedColumnName="id") })
     */

    private $roles;

    /**
     * @var
     * @ORM\OneToMany(targetEntity="ShopBundle\Entity\Product",mappedBy="user")
     *
     *
     */

    private $products;


    /**
     * @ORM\OneToMany(targetEntity="ShopBundle\Entity\Customers", mappedBy="user")
     */

    private $customers;

    /**
     * @ORM\OneToMany(targetEntity="ShopBundle\Entity\Addresses", mappedBy="user")
     */


    private $address;

    /**
     * @var
     *
     * @ORM\Column(name="cache", type="decimal", precision=11, scale=2)
     */


    private $cache;

    /**
     * @return mixed
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * @param mixed $cache
     */
    public function setCache($cache)
    {
        $this->cache = $cache;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getCustomers()
    {
        return $this->customers;
    }

    /**
     * @param mixed $customers
     */
    public function setCustomers($customers)
    {
        $this->customers = $customers;
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param mixed $users
     */
    public function setUsers($users)
    {
        $this->users = $users;
    }


    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->products = new ArrayCollection();

    }

    /**
     * @return Collection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param mixed $products
     */
    public function setProducts($products)
    {
        $this->products = $products;
    }

    /**
     * @param Product $product
     *
     */

    public function setProduct($product)
    {
        $this->setProducts($product);
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
     * @return User
     */
    public function setName($name)
    {
        $this->username = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->username;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
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
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    public function getRoles()
    {
        return array_map(function (Role $r) {

            return $r->getName();

        }, $this->roles->toArray());
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function addRole($role)
    {
        $this->roles->add($role);

    }

    function __toString()
    {
        return $this->username;
    }
}

