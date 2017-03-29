<?php

/**
 * Created by PhpStorm.
 * User: helena
 * Date: 14.3.17
 * Time: 22.22
 */
class Belvg_RenderPrices_Model_Observer
{

    public function core_block_abstract_to_html_after(Varien_Event_Observer $observer)
    {

       if(Mage::helper('belvg_render_prices')->isAllowedConfig())
       {
           if ('catalog/product_price' == $observer->getBlock()->getType() && 'catalog/product/view/tierprices.phtml' != $observer->getBlock()->getTemplate())
           {
               $transport = $observer->getEvent()->getTransport();
               $block = $observer->getEvent()->getBlock();
               $youSaveBlock = $block
                   ->getLayout()
                   ->createBlock(
                       'core/template',
                       'you_save',
                       array(
                           'template' => 'belvg/after.phtml'
                       )
                   )->setProduct($block->getProduct());

               $transport->setHtml($transport->getHtml().$youSaveBlock->toHtml());
           }
       }
       return $this;
    }

    public function catalog_product_load_after(Varien_Event_Observer $observer)
    {
        if(Mage::helper('belvg_render_prices')->isAllowedConfig())
        {
            $product = $observer->getData('product');
            if ($product && $product->getSpecialPrice() && $product->getPrice() > 0)
            {
                $save = Mage::helper('belvg_render_prices')->calcDiscountPercentForSpecialPrice($product);
                if($save)
                {
                    $product->setSave($save);
                }
            }
        }
    }

    public function catalog_product_collection_load_after(Varien_Event_Observer $observer)
    {
        if(Mage::helper('belvg_render_prices')->isAllowedConfig())
        {
            $collection = $observer->getEvent()->getCollection();
            foreach ($collection as $product)
            {
                $save = Mage::helper('belvg_render_prices')->calcDiscountPercentForSpecialPrice($product);
                $product->setData('save', $save);
            }
        }
    }
}



