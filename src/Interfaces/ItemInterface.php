<?php
/**
 * Cart Item interface
 */
namespace Omniship\Interfaces;

/**
 * Cart Item interface
 *
 * This interface defines the functionality that all cart items in
 * the Omniship system are to have.
 */
interface ItemInterface extends ComponentInterface
{
    /**
     * Description of the item
     */
    public function getDescription();
    /**
     * Quantity of the item
     */
    public function getQuantity();
    /**
     * Price of the item
     */
    public function getPrice();
    /**
     * Height of the item
     */
    public function getHeight();
    /**
     * Depth of the item
     */
    public function getDepth();
    /**
     * Width of the item
     */
    public function getWidth();
    /**
     * Weight of the item
     */
    public function getWeight();
}
