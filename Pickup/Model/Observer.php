<?php

class JJ_Pickup_Model_Observer
{
    /**
     * changes the quote item price when it is added to the cart
     *
     * @param Varien_Event_Observer $observer observer object
     *
     * @return boolean
     */
    public function inStoreProductPriceInCart(Varien_Event_Observer $observer)
    {
	/*foreach($_POST as $k => $v){
		error_log("post from instoreprice.php for $k ".$_POST[$k] . "\r\n", 3, "/mnt/hdd2/htdocs/greentop/checkout.log");
	}*/
	//request['shipment-options instore-option
	//request['payment-options pay-instore-option
	
	//created a new product attribute called selected_shipping
	//we want to set the selected shipping method for this item
	// Get the quote item
        $item = $observer->getQuoteItem();
        // Ensure we have the parent item, if it has one
        $item = ( $item->getParentItem() ? $item->getParentItem() : $item );

        // get the selected shipping method from request data
					$instore_ship = $_POST['shipment-options']; //ship-option or instore-option
					//if($_POST['instore_pickup_check'] == "yes"){
						if($_POST['payment-options'] == 'pay-instore-option'){
									$_SESSION['payment'] = "Pay In-Store";
							//make sure price is 0 for pay in-store options (unless they want to add it to their revenue even though the customer hasn't paid yet)
								if($instore_ship != "ship_option"){
									//pay in store and pick up in store
									$_SESSION['shipping'] = "In-store Pickup";
								}else{
									//pay in store and ship to customer
									$_SESSION['shipping'] = "Ship to Customer";
								}
						}else if($_POST['payment-options'] == 'pay-online-option'){
									$_SESSION['payment'] = "Pay Online";
								if($instore_ship != "ship_option"){ 
									//pay online and pick up in store
									$_SESSION['shipping'] = "In-store Pickup";
								}else{								
									//pay online and ship to customer
									$_SESSION['shipping'] = "Ship to Customer";
								}			
						}
					/*}else{ //adding a normal item, no in-store option, still want to display shipping methods in line so set shipping method anyway
								$_SESSION['payment'] = "online";
								$_SESSION['shipping'] = "online";
					}*/

		Mage::getSingleton('core/session')->setPayment($_SESSION['payment']);
		Mage::getSingleton('core/session')->setShipping($_SESSION['shipping']);
        // Set the selected shipping and payment methods of this quote item
		//new function in /app/code/core/Mage/Sales/Model/Quote/Item/Abstract.php or just use setData
		$item->setData('selected_shipping', $_SESSION['shipping']); //must add new entries to sales_flat_quote_item and sales_flat_order_item, not to product itself.
		$item->setData('selected_payment', $_SESSION['payment']);
        // Enable super mode on the product.
        $item->getProduct()->setIsSuperMode(true); //necessary?
 
    return true;
 
    }
}

?>