<?php

namespace FormaLibre\InvoiceBundle\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use Claroline\CoreBundle\Entity\User;

/**
 * @ORM\Table(name="formalibre__shared_workspace")
 * @ORM\Entity()
 */
class SharedWorkspace
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @ORM\Column(type="integer") */
    private $remoteId;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="Claroline\CoreBundle\Entity\User",
     *     cascade={"persist"}
     * )
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    protected $owner;

    /**
     * @ORM\Column(name="end_date", type="datetime", nullable=true)
     */
    private $expDate;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $maxSize;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $maxUser;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $maxRes;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $autoSubscribe = false;

    /**
     * @ORM\OneToMany(
     *     targetEntity="FormaLibre\InvoiceBundle\Entity\Order",
     *     mappedBy="sharedWorkspace"
     * )
     **/
    private $orders;

    public function getId()
    {
        return $this->id;
    }

    public function setOwner(User $owner)
    {
        $this->owner = $owner;
    }

    public function getOwner()
    {
        return $this->owner;
    }

    public function setExpDate(\DateTime $expDate)
    {
        $this->expDate = $expDate;
    }

    public function getExpDate()
    {
        return $this->expDate;
    }

    public function setMaxStorage($maxSize)
    {
        $this->maxSize = $maxSize;
    }

    public function getMaxStorage()
    {
        return $this->maxSize;
    }

    public function setMaxSize($maxSize)
    {
        $this->maxSize = $maxSize;
    }

    public function getMaxSize()
    {
        return $this->maxSize;
    }

    public function setMaxUser($maxUser)
    {
        $this->maxUser = $maxUser;
    }

    public function getMaxUser()
    {
        return $this->maxUser;
    }

    public function setMaxRes($maxRes)
    {
        $this->maxRes = $maxRes;
    }

    public function getMaxRes()
    {
        return $this->maxRes;
    }

    public function setAutoSubscribe($bool)
    {
        $this->autoSubscribe = false;
    }

    public function getAutoSubscribe()
    {
        return $this->autoSubscribe;
    }

    public function setRemoteId($remoteId)
    {
        $this->remoteId = $remoteId;
    }

    public function getRemoteId()
    {
        return $this->remoteId;
    }

    public function getOrders()
    {
        return $this->orders;
    }
}
