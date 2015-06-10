<?php

namespace FormaLibre\InvoiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Payment\CoreBundle\Entity\PaymentInstruction;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="formalibre__order")
 * @ORM\Entity(repositoryClass="FormaLibre\InvoiceBundle\Repository\OrderRepository")
 */
class Order
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @ORM\OneToOne(targetEntity="JMS\Payment\CoreBundle\Entity\PaymentInstruction") */
    private $paymentInstruction;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="FormaLibre\InvoiceBundle\Entity\Product"
     * )
     * @ORM\JoinColumn(name="product_id", onDelete="SET NULL")
     */
    private $product;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="FormaLibre\InvoiceBundle\Entity\PriceSolution"
     * )
     * @ORM\JoinColumn(name="price_solution_id", onDelete="SET NULL")
     */
    private $priceSolution;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $vatAmount;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $vatRate;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $ipAddress;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $countryCode;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $vatNumber;


    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $amount;

    /**
     * @ORM\Column(type="json_array", nullable=true)
     */
    protected $extendedData;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="Claroline\CoreBundle\Entity\User",
     *     cascade={"persist"}
     * )
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=true)
     */
    private $owner;

    /**
     * @ORM\Column(name="creation_date", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $creationDate;

    /**
     * @ORM\Column(name="validation_date", type="datetime", nullable=true)
     */
    protected $validationDate;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $hasDiscout = false;

    public function getId()
    {
        return $this->id;
    }

    public function getPaymentInstruction()
    {
        return $this->paymentInstruction;
    }

    public function setPaymentInstruction(PaymentInstruction $instruction)
    {
        $this->paymentInstruction = $instruction;
    }

    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

    public function setPriceSolution(PriceSolution $priceSolution)
    {
        $this->priceSolution = $priceSolution;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function getPriceSolution()
    {
        return $this->priceSolution;
    }

    public function setCountryCode($code)
    {
        $this->countryCode = $code;
    }

    public function setVatAmount($amount)
    {
        $this->vatAmount = $amount;
    }

    public function getVatAmount()
    {
        return $this->vatAmount;
    }

    public function setVatRate($vatRate)
    {
        $this->vatRate = $vatRate;
    }

    public function getVatRate()
    {
        return $this->vatRate;
    }

    public function setIpAddress($ip)
    {
        $this->ipAddress = $ip;
    }

    public function setVatNumber($number)
    {
        $this->vatNumber = $number;
    }

    public function getVatNumber()
    {
        return $this->vatNumber;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function setIsExecuted($boolean)
    {
        $this->isExecuted = true;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setOwner($user)
    {
        $this->owner = $user;
    }

    public function getOwner()
    {
        return $this->owner;
    }

    public function setExtendedData(array $data)
    {
        $this->extendedData = $data;
    }

    public function getExtendedData()
    {
        return $this->extendedData;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function setValidationDate($date)
    {
        $this->validationDate = $date;
    }

    public function getValidationDate()
    {
        return $this->validationDate;
    }

    public function setHasDiscount($bool)
    {
        $this->hasDiscout = $bool;
    }

    public function hasDiscount()
    {
        return $this->hasDiscout;
    }
}
