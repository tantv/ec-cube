<?php
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2015 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */


namespace Eccube\Entity;

use Eccube\Util\EntityUtil;
use Doctrine\ORM\Mapping as ORM;

/**
 * OrderDetail
 *
 * @ORM\Table(name="dtb_order_detail", indexes={@ORM\Index(name="dtb_order_detail_product_id_key", columns={"product_id"})})
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discriminator_type", type="string", length=255)
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="Eccube\Repository\OrderDetailRepository")
 */
class OrderDetail extends \Eccube\Entity\AbstractEntity
{
    private $price_inc_tax = null;

    public function isPriceChange()
    {
        if (!$this->getProductClass()) {
            return true;
        } elseif ($this->getProductClass()->getPrice02IncTax() === $this->getPriceIncTax()) {
            return false;
        } else {
            return true;
        }
    }

    public function isEnable()
    {
        if ($this->getProductClass() && $this->getProductClass()->isEnable()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Set price IncTax
     *
     * @param  string       $price_inc_tax
     * @return ProductClass
     */
    public function setPriceIncTax($price_inc_tax)
    {
        $this->price_inc_tax = $price_inc_tax;

        return $this;
    }

    /**
     * Get price IncTax
     *
     * @return string
     */
    public function getPriceIncTax()
    {
        return $this->price_inc_tax;
    }

    /**
     * @return integer
     */
    public function getTotalPrice()
    {
        return $this->getPriceIncTax() * $this->getQuantity();
    }

    /**
     * @var int
     *
     * @ORM\Column(name="order_detail_id", type="integer", options={"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="product_name", type="string", length=255)
     */
    private $product_name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="product_code", type="string", length=255, nullable=true)
     */
    private $product_code;

    /**
     * @var string|null
     *
     * @ORM\Column(name="class_name1", type="string", length=255, nullable=true)
     */
    private $class_name1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="class_name2", type="string", length=255, nullable=true)
     */
    private $class_name2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="class_category_name1", type="string", length=255, nullable=true)
     */
    private $class_category_name1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="class_category_name2", type="string", length=255, nullable=true)
     */
    private $class_category_name2;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=0, options={"unsigned":true,"default":0})
     */
    private $price = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="quantity", type="decimal", precision=10, scale=0, options={"unsigned":true,"default":0})
     */
    private $quantity = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="tax_rate", type="decimal", precision=10, scale=0, options={"unsigned":true,"default":0})
     */
    private $tax_rate = 0;

    /**
     * @var int|null
     *
     * @ORM\Column(name="tax_rule", type="smallint", nullable=true, options={"unsigned":true})
     */
    private $tax_rule;

    /**
     * @var \Eccube\Entity\Order
     *
     * @ORM\ManyToOne(targetEntity="Eccube\Entity\Order", inversedBy="OrderDetails")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_id", referencedColumnName="order_id")
     * })
     */
    private $Order;

    /**
     * @var \Eccube\Entity\Product
     *
     * @ORM\ManyToOne(targetEntity="Eccube\Entity\Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="product_id", nullable=true)
     * })
     */
    private $Product;

    /**
     * @var \Eccube\Entity\ProductClass
     *
     * @ORM\ManyToOne(targetEntity="Eccube\Entity\ProductClass")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_class_id", referencedColumnName="product_class_id", nullable=true)
     * })
     */
    private $ProductClass;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set productName.
     *
     * @param string $productName
     *
     * @return OrderDetail
     */
    public function setProductName($productName)
    {
        $this->product_name = $productName;

        return $this;
    }

    /**
     * Get productName.
     *
     * @return string
     */
    public function getProductName()
    {
        return $this->product_name;
    }

    /**
     * Set productCode.
     *
     * @param string|null $productCode
     *
     * @return OrderDetail
     */
    public function setProductCode($productCode = null)
    {
        $this->product_code = $productCode;

        return $this;
    }

    /**
     * Get productCode.
     *
     * @return string|null
     */
    public function getProductCode()
    {
        return $this->product_code;
    }

    /**
     * Set className1.
     *
     * @param string|null $className1
     *
     * @return OrderDetail
     */
    public function setClassName1($className1 = null)
    {
        $this->class_name1 = $className1;

        return $this;
    }

    /**
     * Get className1.
     *
     * @return string|null
     */
    public function getClassName1()
    {
        return $this->class_name1;
    }

    /**
     * Set className2.
     *
     * @param string|null $className2
     *
     * @return OrderDetail
     */
    public function setClassName2($className2 = null)
    {
        $this->class_name2 = $className2;

        return $this;
    }

    /**
     * Get className2.
     *
     * @return string|null
     */
    public function getClassName2()
    {
        return $this->class_name2;
    }

    /**
     * Set classCategoryName1.
     *
     * @param string|null $classCategoryName1
     *
     * @return OrderDetail
     */
    public function setClassCategoryName1($classCategoryName1 = null)
    {
        $this->class_category_name1 = $classCategoryName1;

        return $this;
    }

    /**
     * Get classCategoryName1.
     *
     * @return string|null
     */
    public function getClassCategoryName1()
    {
        return $this->class_category_name1;
    }

    /**
     * Set classCategoryName2.
     *
     * @param string|null $classCategoryName2
     *
     * @return OrderDetail
     */
    public function setClassCategoryName2($classCategoryName2 = null)
    {
        $this->class_category_name2 = $classCategoryName2;

        return $this;
    }

    /**
     * Get classCategoryName2.
     *
     * @return string|null
     */
    public function getClassCategoryName2()
    {
        return $this->class_category_name2;
    }

    /**
     * Set price.
     *
     * @param string $price
     *
     * @return OrderDetail
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price.
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set quantity.
     *
     * @param string $quantity
     *
     * @return OrderDetail
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity.
     *
     * @return string
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set taxRate.
     *
     * @param string $taxRate
     *
     * @return OrderDetail
     */
    public function setTaxRate($taxRate)
    {
        $this->tax_rate = $taxRate;

        return $this;
    }

    /**
     * Get taxRate.
     *
     * @return string
     */
    public function getTaxRate()
    {
        return $this->tax_rate;
    }

    /**
     * Set taxRule.
     *
     * @param int|null $taxRule
     *
     * @return OrderDetail
     */
    public function setTaxRule($taxRule = null)
    {
        $this->tax_rule = $taxRule;

        return $this;
    }

    /**
     * Get taxRule.
     *
     * @return int|null
     */
    public function getTaxRule()
    {
        return $this->tax_rule;
    }

    /**
     * Set order.
     *
     * @param \Eccube\Entity\Order|null $order
     *
     * @return OrderDetail
     */
    public function setOrder(\Eccube\Entity\Order $order = null)
    {
        $this->Order = $order;

        return $this;
    }

    /**
     * Get order.
     *
     * @return \Eccube\Entity\Order|null
     */
    public function getOrder()
    {
        return $this->Order;
    }

    /**
     * Set product.
     *
     * @param \Eccube\Entity\Product|null $product
     *
     * @return OrderDetail
     */
    public function setProduct(\Eccube\Entity\Product $product = null)
    {
        $this->Product = $product;

        return $this;
    }

    /**
     * Get product.
     *
     * @return \Eccube\Entity\Product|null
     */
    public function getProduct()
    {
        if (EntityUtil::isEmpty($this->Product)) {
            return null;
        }
        return $this->Product;
    }

    /**
     * Set productClass.
     *
     * @param \Eccube\Entity\ProductClass|null $productClass
     *
     * @return OrderDetail
     */
    public function setProductClass(\Eccube\Entity\ProductClass $productClass = null)
    {
        $this->ProductClass = $productClass;

        return $this;
    }

    /**
     * Get productClass.
     *
     * @return \Eccube\Entity\ProductClass|null
     */
    public function getProductClass()
    {
        return $this->ProductClass;
    }
}
