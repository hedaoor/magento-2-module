<?php

namespace Rahul\Wishlist\Helper;
use \Magento\Framework\App\Helper\AbstractHelper;
 
class Data extends AbstractHelper
{
    /**
	* Recipient email config path
	*/
	const XML_PATH_ACTIVE = 'ajaxwishlist_section/ajaxwishlist_grp/active';
	
	protected $scopeConfig;
	protected $storeManager;

	public function __construct(
		\Magento\Framework\App\Helper\Context $context,
		\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
		\Magento\Store\Model\StoreManagerInterface $storeManager
		) {
		parent::__construct($context);
		$this->scopeConfig = $scopeConfig;
		$this->storeManager = $storeManager;
	}

	public function getStoreConfig($path){
		$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;

	    return $this->scopeConfig->getValue($path, $storeScope);
	}

	public function isEnable(){
		if($this->getStoreConfig(self::XML_PATH_ACTIVE)){
			return true;
		}
		else{
			return false;
		}
	}
}