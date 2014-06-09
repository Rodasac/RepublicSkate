<?php
// src/Product.php
use Doctrine\ORM\EntityRepository;
/**
 * @Entity(repositoryClass="ProductRepository") @Table(name="products")
 **/
class Product
{
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
    
    /**
     * @Column(type="string")
     */
    private $imagen;
    
    /**
     * @ManyToOne(targetEntity="Category")
     * @JoinColumn(name="category_id", referencedColumnName="id")
     **/
    private $categoria;
    
    /**
     * @Column(type="integer")
     */
    private $precio;
    
    /**
     * @Column(type="integer")
     */
    private $cantidad;
    
    /** 
     * @Column(type="datetime", name="saved_at") 
     */
    private $savedAt;

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
     * @return Product
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
     * @return Product
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

    /**
     * Set imagen
     *
     * @param string $imagen
     * @return Product
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * Get imagen
     *
     * @return string 
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * Set precio
     *
     * @param integer $precio
     * @return Product
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get precio
     *
     * @return integer 
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     * @return Product
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer 
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set savedAt
     *
     * @param \DateTime $savedAt
     * @return Product
     */
    public function setSavedAt($savedAt)
    {
        $this->savedAt = $savedAt;

        return $this;
    }

    /**
     * Get savedAt
     *
     * @return \DateTime 
     */
    public function getSavedAt()
    {
        return $this->savedAt;
    }

    /**
     * Set categoria
     *
     * @param \Category $categoria
     * @return Product
     */
    public function setCategoria(\Category $categoria = null)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return \Category 
     */
    public function getCategoria()
    {
        return $this->categoria;
    }
}

class ProductRepository extends EntityRepository {
    public function  getOrderDesc () {
        $query = $this->_em->createQuery("SELECT p FROM Product p ORDER BY p.id DESC");
        return $query->getResult();
    }

    public function  getPag ($page) {
        return $query = $this->_em->createQuery("SELECT p, c FROM Product p JOIN p.categoria c ORDER BY p.id DESC")
            ->setFirstResult(6 * ($page - 1 ))
            ->setMaxResults(6);
    }

    public function searchName ($name, $page){
        return $query = $this->_em->createQuery("SELECT p, c FROM Product p JOIN p.categoria c WHERE p.name LIKE :name ORDER BY p.id DESC")
            ->setFirstResult(6 * ($page - 1))
            ->setMaxResults(6)
            ->setParameter('name', '%'.$name.'%');
    }

    public function searchCat ($id, $page, $num){
        return $query = $this->_em->createQuery("SELECT p, c FROM Product p JOIN p.categoria c WHERE c = :id ORDER BY p.id DESC")
            ->setFirstResult($num * ($page - 1))
            ->setMaxResults($num)
            ->setParameter('id', $id);
    }
}
