<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Base\MoneyInterface;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Money
 * @ORM\Embeddable()
 */
class Money implements MoneyInterface
{
    /**
     * @var int
     * @JMS\Type("integer")
     *
     * @ORM\Column(name="euros", type="integer")
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual(0)
     * @JMS\Expose()
     */
    private $euros = 0;

    /**
     * @var int
     * @JMS\Type("integer")
     *
     * @ORM\Column(name="cents", type="integer")
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual(0)
     * @JMS\Expose()
     */
    private $cents = 0;

    public function setCents(int $cents): MoneyInterface
    {
        $this->setEuros($this->getEuros() + $cents / 100);
        $this->cents = $cents % 100;

        return $this;
    }

    public function getCents(): int
    {
        return $this->cents;
    }

    public function setEuros(int $euros): MoneyInterface
    {
        $this->euros = $euros;

        return $this;
    }

    public function getEuros(): int
    {
        return $this->euros;
    }

    public function getTotalCents(): int
    {
        return $this->getEuros() * 100 + $this->getCents();
    }
}
