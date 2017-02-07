<?php

namespace AppBundle\Form;

use AppBundle\Entity\Money;
use Symfony\Component\Form\DataTransformerInterface;

class PriceTransformer implements DataTransformerInterface
{
    /**
     * @inheritdoc
     */
    public function transform($value)
    {
        return [
            'euros' => $value->getEuros(),
            'cents' => $value->getCents(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function reverseTransform($value)
    {
        $money = new Money();
        $money->setEuros($value['euros']);
        $money->setCents($value['cents']);

        return $money;
    }
}
