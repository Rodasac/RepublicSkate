<?php
// src/Product.php
use Doctrine\ORM\EntityRepository;

/**
 * @Entity(repositoryClass="NovedadesRepository") @Table(name="novedades")
 **/
class Novedades {
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
     * @Column(type="datetime", name="saved_at")
     */
    private $savedAt;

    /**
     * @Column(type="datetime", name="update_at", nullable=true)
     */
    private $updateAt;

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
     * @return Novedades
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
     * @return Novedades
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
     * @return Novedades
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
     * Set savedAt
     *
     * @param \DateTime $savedAt
     * @return Novedades
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
     * Set updateAt
     *
     * @param \DateTime $updateAt
     * @return Novedades
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get updateAt
     *
     * @return \DateTime 
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }
}

class NovedadesRepository extends EntityRepository {
    public function  getOrderDesc () {
        return $this->_em->createQuery("SELECT n FROM Novedades n ORDER BY n.id DESC")
                         ->getResult();
    }
    public function  getPaginationDesc ($page) {
        return $this->_em->createQuery("SELECT n FROM Novedades n ORDER BY n.id DESC")
            ->setFirstResult(0 * ($page - 1))
            ->setMaxResults(50);
    }
}
