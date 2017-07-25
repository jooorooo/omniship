<?php
/**
 * Shipping Piece Bag
 */
namespace Omniship\Common;

use Omniship\Helper\Collection;
use Omniship\Interfaces\PieceInterface;

/**
 * Shipping Piece Bag
 *
 * This class defines a bag (multi element set or array) of single shipping pieces
 * in the Omniship system.
 *
 * @see Piece
 */
class PieceBag extends Collection
{

    /**
     * Create a new collection.
     *
     * @param  mixed  $pieces
     */
    public function __construct($pieces = [])
    {
        $pieces = array_map(function($piece) {
            return !($piece instanceof PieceInterface) ? new Piece($piece) : $piece;
        }, $pieces);
        parent::__construct($pieces);
    }

    /**
     * Set the piece at a given offset.
     *
     * @param  mixed  $key
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($key, $value)
    {
        if(!($value instanceof PieceInterface)) {
            $value = new Piece($value);
        }
        parent::offsetSet($key, $value);
    }

    /**
     * Get all of the pieces in the collection.
     *
     * @return Piece[]
     */
    public function all()
    {
        return parent::all();
    }
}
