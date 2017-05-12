<?php

namespace Rahul\Outofstock\Observer;

use Magento\Framework\Event\ObserverInterface;

class Productsaveafter implements ObserverInterface
{    
	protected $stockinterface;
	protected $_subscriber;
    protected $data;
    protected $_configurable;
	protected $_product;

	public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\CatalogInventory\Api\StockStateInterface $stockinterface,
        \Rahul\Outofstock\Model\Subscriber $subscriber,
        \Rahul\Outofstock\Helper\Data $data,
        \Magento\ConfigurableProduct\Model\ResourceModel\Product\Type\Configurable $configurable,
        \Magento\Catalog\Model\Product $product
    ) {
    	$this->stockinterface = $stockinterface;
        $this->_subscriber = $subscriber;
        $this->data = $data;
        $this->_configurable = $configurable;
        $this->_product = $product;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if($this->data->checkModule()){        
            $_product = $observer->getEvent()->getProduct();  

            $config = $this->_configurable->getParentIdsByChild($_product->getId());
                    
            if(!empty($config[0])){
                $product_id = $config[0];
            }
            else{
                $product_id = $_product->getId();   
            }
            
            if($this->_product->load($product_id)->isAvailable()){
               
            	$subscribers = $this->_subscriber->getCollection()
            									->addFieldToFilter('is_active',1)
            									->addFieldToFilter('product_id',$product_id);
                
            	foreach ($subscribers as $subscriber) {
            		$subscriber->setIsActive(0);
            		$subscriber->save();
            		$this->data->sendEmail($subscriber->getEmail(),$this->_product);
            	}
            }
        }
    }   
}