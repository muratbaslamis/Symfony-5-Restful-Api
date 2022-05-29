<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SiparislerRepository")
 * @ORM\Table(name="siparisler", options={"collate"="utf8mb4_unicode_ci"})
 */
class Siparisler
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;



    /**
     * @ORM\Column(type="string")
     */
    private $orderCode;


    /**
     * @ORM\Column(type="integer")
     */
    private $productid;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="text")
     */
    private $address;

    /**
     * @ORM\Column(type="datetime")
    */
    private $shippingDate;

    /**
     * @ORM\ManyToMany(targetEntity="User")
     * @ORM\Column(type="integer")
     */
    private $kullaniciid;



    public function setOrderCode($orderCode)
    {
        $this->orderCode = $orderCode;
    }

    public function getProductid()
    {
        return $this->productid;
    }

    public function setProductid($productid)
    {
        $this->productid = $productid;

        return $this;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }
        public function setKullaniciid($kullaniciid)
    {
        $this->kullaniciid = $kullaniciid;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function setShippingDate($shippingDate)
    {
        $this->shippingDate = $shippingDate;
    }

    public function getId()
    {
        return $this->id;
    }



    public function getOrderCode()
    {
        return $this->orderCode;
    }




    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getKullaniciid()
    {
        return $this->kullaniciid;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getShippingDate()
    {
        return $this->shippingDate;
    }

}