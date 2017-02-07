<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Base\ProductInterface;
use AppBundle\Entity\Base\StockInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

class StockRepository extends EntityRepository implements StockInterface
{
    /**
     * @param ProductInterface $product
     *
     * @return StockInterface
     */
    public function addProduct(ProductInterface $product): StockInterface
    {
        $em = $this->getEntityManager();
        $em->persist($product);
        $em->flush();

        return $this;
    }

    public function removeProduct(ProductInterface $product): StockInterface
    {
        $em = $this->getEntityManager();
        $em->remove($product);
        $em->flush();

        return $this;
    }

    public function getProducts(): ArrayCollection
    {
        return new ArrayCollection($this->findAll());
    }
}
