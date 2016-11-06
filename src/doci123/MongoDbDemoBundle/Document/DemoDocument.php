<?php
/**
 *
 *
 * Mapping field type
 * http://docs.doctrine-project.org/projects/doctrine-mongodb-odm/en/latest/reference/basic-mapping.html
 */
namespace doci123\MongoDbDemoBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(repositoryClass="doci123\MongoDbDemoBundle\Repository\DemoRepository")
 */
class DemoDocument
{
    /**
     * No Db Property
     * @var string
     */
    public $demoProperty = "Public property in class BikeModel";

    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $name;

    /**
     * @MongoDB\Field(type="float")
     */
    protected $price;

    /**
     * Schema-less dynamic properties here
     * @MongoDB\Field(type="hash")
     */
    public $attributes;

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * Get price
     *
     * @return float $price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return mixed
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param mixed $attributes
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }
}
