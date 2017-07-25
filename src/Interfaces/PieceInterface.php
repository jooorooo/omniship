<?php
/**
 * Cart Piece interface
 */
namespace Omniship\Interfaces;

/**
 * Cart Piece interface
 *
 * This interface defines the functionality that all cart items in
 * the Omniship system are to have.
 */
interface PieceInterface extends ComponentInterface
{
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
