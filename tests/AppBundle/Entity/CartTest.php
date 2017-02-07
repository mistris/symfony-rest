<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Cart;
use AppBundle\Entity\Money;
use AppBundle\Entity\Product;
use PHPUnit_Framework_TestCase;

class CartTest extends PHPUnit_Framework_TestCase
{
    public function testCartProducts()
    {
        // Check if new cart is empty (doesn't contain any product)
        $cart = new Cart();
        $this->assertEquals(0, $cart->getProducts()->count());

        // Add first product to cart
        $priceA = new Money();
        $priceA->setEuros(10);
        $priceA->setCents(60);

        $productA = new Product();
        $productA->setPrice($priceA);
        $productA->setVatRate(0.5);

        $cart->addProduct($productA);

        // Check if cart subtotal is correct
        $this->assertEquals(10, $cart->getSubtotal()->getEuros());
        $this->assertEquals(60, $cart->getSubtotal()->getCents());

        // Check if cart VAT amount is correct
        $this->assertEquals(5, $cart->getVatAmount()->getEuros());
        $this->assertEquals(30, $cart->getVatAmount()->getCents());

        // Check if cart total is correct
        $this->assertEquals(15, $cart->getTotal()->getEuros());
        $this->assertEquals(90, $cart->getTotal()->getCents());

        // Add another product to cart
        $priceB = new Money();
        $priceB->setEuros(1);
        $priceB->setCents(50);

        $productB = new Product();
        $productB->setPrice($priceB);
        $productB->setVatRate(0.2);

        $cart->addProduct($productB);

        // Check if cart subtotal is still correct
        $this->assertEquals(12, $cart->getSubtotal()->getEuros());
        $this->assertEquals(10, $cart->getSubtotal()->getCents());

        // Check if cart VAT amount is still correct
        $this->assertEquals(5, $cart->getVatAmount()->getEuros());
        $this->assertEquals(60, $cart->getVatAmount()->getCents());

        // Check if cart total is still correct
        $this->assertEquals(17, $cart->getTotal()->getEuros());
        $this->assertEquals(70, $cart->getTotal()->getCents());
    }
}
