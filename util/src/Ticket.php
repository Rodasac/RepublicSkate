<?php
// src/Ticket.php
use Doctrine\ORM\EntityRepository;
/**
 * @Entity(repositoryClass="TicketRepository") @Table(name="tickets")
 **/
class Ticket {
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="string")
     */
    private $user;

    /**
     * @Column(type="boolean")
     */
    private $status;

    /**
     * @Column(type="datetime", name="fecha")
     */
    private $fecha;

    /**
     * @Column(type="text")
     */
    private $products;

    public function __construct()
    {
        $this->fecha = new \DateTime('now');
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
     * @param string $user
     * @return Ticket
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return Ticket
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Ticket
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set products
     *
     * @param string $products
     * @return Ticket
     */
    public function setProducts($products)
    {
        $this->products = $products;

        return $this;
    }

    /**
     * Get products
     *
     * @return string
     */
    public function getProducts()
    {
        return $this->products;
    }
}

class TicketRepository extends EntityRepository {
    public function getPag($page, $num){
        return $query = $this->_em->createQuery("SELECT t FROM Ticket t ORDER BY t.id DESC")
            ->setFirstResult($num * ($page - 1))
            ->setMaxResults($num);
    }
}
