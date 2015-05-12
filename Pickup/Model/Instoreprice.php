<?php
class JJ_Pickup_Model_Instoreprice
{
 
    /**
     * Checks whether a product is supposed to available for in-store pickup only, and if so
	 * changes the shipping methods available in cart and checkout accordingly.
     * Change name of method to inStoreProductSelectedShippingInCart
     * @param Varien_Event_Observer $observer observer object
     *
     * @return boolean
     */
    public function inStoreProductPriceInCart(Varien_Event_Observer $observer)
    {

    }
}