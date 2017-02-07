<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Base\MoneyInterface;
use AppBundle\Entity\Base\ProductInterface;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StockRepository")
 * @ORM\ChangeTrackingPolicy(value="DEFERRED_EXPLICIT")
 * @JMS\ExclusionPolicy("all")
 */
class Product implements ProductInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Expose()
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     * @Assert\Length(max=100, min=3)
     * @JMS\Expose()
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="available", type="integer")
     * @Assert\GreaterThanOrEqual(0)
     * @JMS\Expose()
     */
    private $available = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="vat_rate", type="decimal", precision=4, scale=2)
     * @Assert\GreaterThanOrEqual(0)
     * @JMS\Expose()
     */
    private $vatRate = 0;

    /**
     * @var Money
     * @JMS\Type("AppBundle\Entity\Money")
     *
     * @ORM\Embedded(class="Money")
     * @Assert\Valid()
     * @JMS\Expose()
     */
    private $price;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function setName(string $name): ProductInterface
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setAvailable(int $available): ProductInterface
    {
        $this->available = $available;

        return $this;
    }

    public function getAvailable(): int
    {
        return $this->available;
    }

    public function setPrice(MoneyInterface $price): ProductInterface
    {
        $this->price = $price;

        return $this;
    }

    public function getPrice(): MoneyInterface
    {
        return $this->price;
    }

    public function setVatRate(float $vat): ProductInterface
    {
        $this->vatRate = $vat;

        return $this;
    }

    public function getVatRate(): float
    {
        return $this->vatRate;
    }

    /**
     * Get total (price + VAT) in cents
     *
     * @return int
     */
    public function getTotalInCents(): int
    {
        $totalCents = $this->getPrice()->getTotalCents();
        $vatAmount = $totalCents * $this->getVatRate();

        return $totalCents + $vatAmount;
    }

    /**
     * Get vat amount in cents
     * @return int
     */
    public function getVatAmountInCents(): int
    {
        return $this->getPrice()->getTotalCents() * $this->getVatRate();
    }
}
