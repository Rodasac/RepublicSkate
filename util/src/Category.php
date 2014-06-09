<?php
// src/Category.php
use Doctrine\ORM\EntityRepository;
/**
 * @Entity(repositoryClass="CategoryRepository") @Table(name="category")
 **/
 class Category {
     /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;
    
    /**
     * @Column(type="string", unique=true)
     */
    private $name;
    
     /**
     * @Column(type="text")
     */
    private $descripcion;

     public function __construct()
     {
         $this->savedAt = new \DateTime('now');
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
     * Set name
     *
     * @param string $name
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return Category
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }
}

class CategoryRepository extends EntityRepository {
    public function  getOrderDesc () {
        return $this->_em->createQuery("SELECT c FROM Category c ORDER BY c.name DESC")
                         ->getResult();
    }

    public function getPag ($page) {
        return $query = $this->_em->createQuery("SELECT c FROM Category c ORDER BY c.name DESC")
            ->setFirstResult(14 * ($page - 1 ))
            ->setMaxResults(14);
    }
}
