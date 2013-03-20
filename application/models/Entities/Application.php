<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entities\Application
 */
class Application
{
    /**
     * @var string $name
     */
    private $name;

    /**
     * @var string $description
     */
    private $description;

    /**
     * @var float $price
     */
    private $price;

    /**
     * @var \DateTime $createdDate
     */
    private $createdDate;

    /**
     * @var boolean $published
     */
    private $published;

    /**
     * @var \DateTime $publishedDate
     */
    private $publishedDate;

    /**
     * @var string $version
     */
    private $version;

    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var Entities\User
     */
    private $user;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $taxonomies;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->taxonomies = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set name
     *
     * @param string $name
     * @return Application
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
     * Set description
     *
     * @param string $description
     * @return Application
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
     * @param float $price
     * @return Application
     */
    public function setPrice($price)
    {
        $this->price = $price;
    
        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return Application
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;
    
        return $this;
    }

    /**
     * Get createdDate
     *
     * @return \DateTime 
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set published
     *
     * @param boolean $published
     * @return Application
     */
    public function setPublished($published)
    {
        $this->published = $published;
    
        return $this;
    }

    /**
     * Get published
     *
     * @return boolean 
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set publishedDate
     *
     * @param \DateTime $publishedDate
     * @return Application
     */
    public function setPublishedDate($publishedDate)
    {
        $this->publishedDate = $publishedDate;
    
        return $this;
    }

    /**
     * Get publishedDate
     *
     * @return \DateTime 
     */
    public function getPublishedDate()
    {
        return $this->publishedDate;
    }

    /**
     * Set version
     *
     * @param string $version
     * @return Application
     */
    public function setVersion($version)
    {
        $this->version = $version;
    
        return $this;
    }

    /**
     * Get version
     *
     * @return string 
     */
    public function getVersion()
    {
        return $this->version;
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
     * Set user
     *
     * @param Entities\User $user
     * @return Application
     */
    public function setUser(\Entities\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return Entities\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add taxonomies
     *
     * @param Entities\Taxonomy $taxonomies
     * @return Application
     */
    public function addTaxonomie(\Entities\Taxonomy $taxonomies)
    {
        $this->taxonomies[] = $taxonomies;
    
        return $this;
    }

    /**
     * Remove taxonomies
     *
     * @param Entities\Taxonomy $taxonomies
     */
    public function removeTaxonomie(\Entities\Taxonomy $taxonomies)
    {
        $this->taxonomies->removeElement($taxonomies);
    }

    /**
     * Get taxonomies
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTaxonomies()
    {
        return $this->taxonomies;
    }
}
