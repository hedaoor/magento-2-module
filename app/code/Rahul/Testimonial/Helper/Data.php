<?php

namespace Rahul\Testimonial\Helper;
use \Magento\Framework\App\Helper\AbstractHelper;
 
class Data extends AbstractHelper
{
   
	const XML_PATH_ACTIVE = 'testimonial_section/testimonial_grp/enable';
	const XML_PATH_SIDEBARACTIVE = 'testimonial_section/testimonial_grp/sidebar_enable';
	
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

	public function checkModule(){
		if($this->getStoreConfig(self::XML_PATH_ACTIVE)){
			return true;
		}
		else{
			return false;
		}
	}

	public function isSidebarEnable(){
		if($this->getStoreConfig(self::XML_PATH_SIDEBARACTIVE)){
			return true;
		}
		else{
			return false;
		}
	}

	public function getImagePath($result){
		if(array_key_exists('file_path',$result)){
			return $result['file_path'];
		}
		else{
			return $result['name'];	
		}		
	}
}