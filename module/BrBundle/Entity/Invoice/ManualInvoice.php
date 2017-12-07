<?php
/**
 * Litus is a project by a group of students from the KU Leuven. The goal is to create
 * various applications to support the IT needs of student unions.
 *
 * @author Niels Avonds <niels.avonds@litus.cc>
 * @author Karsten Daemen <karsten.daemen@litus.cc>
 * @author Koen Certyn <koen.certyn@litus.cc>
 * @author Bram Gotink <bram.gotink@litus.cc>
 * @author Dario Incalza <dario.incalza@litus.cc>
 * @author Pieter Maene <pieter.maene@litus.cc>
 * @author Kristof Mariën <kristof.marien@litus.cc>
 * @author Lars Vierbergen <lars.vierbergen@litus.cc>
 * @author Daan Wendelen <daan.wendelen@litus.cc>
 * @author Mathijs Cuppens <mathijs.cuppens@litus.cc>
 * @author Floris Kint <floris.kint@vtk.be>
 *
 * @license http://litus.cc/LICENSE
 */

namespace BrBundle\Entity\Invoice;

use BrBundle\Entity\Collaborator,
    BrBundle\Entity\Company,
    Doctrine\ORM\EntityManager,
    Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="BrBundle\Repository\Invoice\ManualInvoice")
 * @ORM\Table(name="br.invoices_manual")
 */
class ManualInvoice extends \BrBundle\Entity\Invoice
{
    /**
     * @var int The price (VAT excluded!) a company has to pay when they agree to this product of the manual invoice
     *
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @var Collaborator The person who created this node
     *
     * @ORM\ManyToOne(targetEntity="BrBundle\Entity\Collaborator")
     * @ORM\JoinColumn(name="author", referencedColumnName="id")
     */
    private $author;

    /**
     * @var Company The company used in this manual invoice
     *
     * @ORM\ManyToOne(targetEntity="BrBundle\Entity\Company")
     * @ORM\JoinColumn(name="company", referencedColumnName="id")
     */
    private $company;

    /**
     * @var int The paymentdays of the manual invoice
     *
     * @ORM\Column(name="payment_days", type="integer", options={"default" = 30})
     */
    private $paymentDays;

    /**
     * @var string The title of the manual invoice
     *
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @var boolean that reflects if the product is a refund.
     *
     * @ORM\Column(name="refund", type="boolean", options={"default" = false})
     */
    private $refund;

    public function __construct(EntityManager $entityManager, Collaborator $person)
    {
        parent::__construct($entityManager);

        $this->setAuthor($person);
    }

    /**
     * @return bool
     */
    public function hasContract()
    {
        return false;
    }

    /**
     * @param  boolean $refund the boolean to set
     * @return self
     */
    public function setRefund($refund)
    {
        $this->refund = $refund;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isRefund()
    {
        return $this->refund;
    }

    /**
     * @param  float $price
     * @return self
     */
    public function setPrice($price)
    {
        if (null === $price || !preg_match('/^[0-9]+.?[0-9]{0,2}$/', $price)) {
            throw new InvalidArgumentException('Invalid price');
        }

        $this->price = (int) ($price);

        return $this;
    }

    /**
     * @return int price in cents
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return int price in cents with sign
     */
    public function getSignedPrice()
    {
        $sign = 1;
        if ($this->isRefund()) {
            $sign = -1;
        }

        return $sign * $this->price;
    }

    /**
     * @return double price
     */
    public function getExclusivePrice()
    {
        return ((double) $this->getSignedPrice()) / 100;
    }

    /**
     * @return int
     */
    public function getPaymentDays()
    {
        return $this->paymentDays;
    }

    /**
     * @param  int  $paymentDays
     * @return self
     */
    public function setPaymentDays($paymentDays)
    {
        $this->paymentDays = $paymentDays;

        return $this;
    }

    /**
     * @return Collaborator
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @throws InvalidArgumentException
     * @param  Collaborator             $author
     * @return self
     */
    public function setAuthor(Collaborator $author)
    {
        if (null === $author) {
            throw new InvalidArgumentException('Author cannot be null');
        }

        $this->author = $author;

        return $this;
    }

    /**
     * @return Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @throws InvalidArgumentException
     * @param  Company                  $company
     * @return self
     */
    public function setCompany(Company $company)
    {
        if (null === $company) {
            throw new InvalidArgumentException('Company cannot be null');
        }

        $this->company = $company;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @throws InvalidArgumentException
     * @param  string                   $title The title of the contract
     * @return self
     */
    public function setTitle($title)
    {
        if (null === $title || !is_string($title)) {
            throw new InvalidArgumentException('Invalid title');
        }

        $this->title = $title;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getExpirationTime()
    {
        $expireTime = 'P' . $this->getOrder()->getContract()->getPaymentDays() . 'D';

        return $this->getCreationTime()->add(new DateInterval($expireTime));
    }
}