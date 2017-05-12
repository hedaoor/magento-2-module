<?php

namespace Rahul\Testimonial\Block\Index;


class Index extends \Magento\Framework\View\Element\Template {

	protected $_testimonial;

    protected $_Collection;

	protected $_ColFactory;

	protected $scopeConfig;
	
	protected $helper;
    protected $_storeManager;
    protected $_storeManager1;

	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Rahul\Testimonial\Model\ResourceModel\Testimonial\CollectionFactory $collectionFactory,
		\Rahul\Testimonial\Helper\Data $helper,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
		\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
		array $data = []
		) 
	{
		$this->_ColFactory = $collectionFactory;
		$this->scopeConfig = $scopeConfig;	
		$this->helper = $helper;
        $this->_storeManager = $storeManager;
        // $this->_storeConfig = $scopeConfig;
		parent::__construct(
			$context,
			$data
			);
	}
	
	public function _prepareLayout()
	{
		$this->_Collection = $this->_ColFactory->create();
		parent::_prepareLayout();
		if ($this->_Collection->getData()) {
            // create pager block for collection
            $pager = $this->getLayout()->createBlock('Magento\Theme\Block\Html\Pager','my.custom.pager');
          	
            $pageSize =($this->helper->getStoreConfig('testimonial_section/testimonial_grp/perpage'))? $this->helper->getStoreConfig('testimonial_section/testimonial_grp/perpage') : 5;
          	// assign collection to pager
            $pager->setLimit($pageSize)->setCollection($this->getTestimonial());
            
            // set pager block in layout
            $this->setChild('pager', $pager);
        }
        return $this;
	}

	public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    public function getTestimonial(){
    	//get values of current page
        $page = ($this->getRequest()->getParam('p'))? $this->getRequest()->getParam('p') : 1;
    	//get values of current limit
        $pageSize =($this->helper->getStoreConfig('testimonial_section/testimonial_grp/perpage'))? $this->helper->getStoreConfig('testimonial_section/testimonial_grp/perpage') : 5;

        
    	$collection = 	$this->_ColFactory->create();
    	$collection->addFieldToFilter('is_active',1);
    	$collection->setPageSize($pageSize);
        $collection->setCurPage($page);
    	return $collection;
    }

    public function isModeleEnable(){
    	return $this->helper->isSidebarEnable();
    }

    public function getAvtarPath($avtar){
                
        $placeholder = $this->helper->getStoreConfig('testimonial_section/testimonial_grp/avtar_placeholder');

        if(empty($avtar))
        {
           //echo $this->_storeManager1->getStore()->getConfig('catalog/placeholder/thumbnail_placeholder');exit;
            return $this ->_storeManager-> getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA ).'Testimonial/'.$placeholder;
        }
        else{
            return $this ->_storeManager-> getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA ).$avtar;
        }       
        
    }
}