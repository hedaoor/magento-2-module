<?php

namespace Rahul\Outofstock\Block\Index;


class Index extends \Magento\Framework\View\Element\Template {

	protected $stockinterface;
    protected $_registry;
	protected $helper;

    public function __construct(
    	\Magento\Catalog\Block\Product\Context $context, 
    	\Magento\Framework\Registry $registry,
        \Rahul\Outofstock\Helper\Data $helper,
    	\Magento\CatalogInventory\Api\StockStateInterface $stockinterface,
    	array $data = []
    )
    {
    	// echo "Asdasdasd";exit;
         $this->_registry = $registry;
    	 $this->helper = $helper;
    	 // echo $this->_registry->registry('current_product');exit;
    	$this->stockinterface = $stockinterface;
        parent::__construct($context, $data);

    }

    public function getStock($product){

    	return $this->stockinterface->getStockQty($product->getId(), $product->getStore()->getWebsiteId());
    }

    public function getCurrentProduct()
    {    
    	// echo "aaaaaaaaa";exit;   
        return $this->_registry->registry('current_product');
    }  

    public function enable()
	{
	    return $this->helper->checkModule();
	}
}