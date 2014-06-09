<?php
// src/Perfil.php
use Doctrine\ORM\EntityRepository;
/**
 * @Entity @Table(name="perfil")
 **/
class Perfil {
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;
    /**
     * @Column(type="integer", unique=true)
     */
    private $user_id;
    /**
     * @Column(type="integer", unique=true)
     */
    private $ci;
    /**
     * @Column(type="string")
     */
    private $rif;

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
     * Set user_id
     *
     * @param integer $userId
     * @return Perfil
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;

        return $this;
    }

    /**
     * Get user_id
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set ci
     *
     * @param integer $ci
     * @return Perfil
     */
    public function setCi($ci)
    {
        $this->ci = $ci;

        return $this;
    }

    /**
     * Get ci
     *
     * @return integer 
     */
    public function getCi()
    {
        return $this->ci;
    }

    /**
     * Set rif
     *
     * @param string $rif
     * @return Perfil
     */
    public function setRif($rif)
    {
        $this->rif = $rif;

        return $this;
    }

    /**
     * Get rif
     *
     * @return string 
     */
    public function getRif()
    {
        return $this->rif;
    }
}
