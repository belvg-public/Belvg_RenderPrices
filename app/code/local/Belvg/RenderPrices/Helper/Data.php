<?php
/**
 * Created by PhpStorm.
 * User: helena
 * Date: 14.3.17
 * Time: 22.22
 */
class Belvg_RenderPrices_Helper_Data extends Mage_Core_Helper_Abstract {

    public function calcDiscountPercentForSpecialPrice($product)
    {
        if($product)
        {
            $specialPrice = $product->getSpecialPrice();
            $price = $product->getPrice();
            if($price && $specialPrice)
            {
                $res = 100 - (round(($specialPrice * 100) / $price, 0, PHP_ROUND_HALF_DOWN));
                return $this->__("You Save %s%%", $res);
            }
            return null;
        }
    }

    public function isAllowedConfig()
    {
        $current_store = Mage::app()->getStore()->getStoreId();
        if(!(Mage::getStoreConfigFlag('catalog/price/belvg_render_price', $current_store)))
        {
            return false;
        }
        return true;
    }

}
