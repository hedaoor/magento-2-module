<?php

namespace Rahul\Outofstock\Helper;
use \Magento\Framework\App\Helper\AbstractHelper;
 
class Data extends AbstractHelper
{
    /**
	* Recipient email config path
	*/
	const XML_PATH_EMAIL_RECIPIENT = 'contact/email/recipient_email';
	const XML_PATH_ACTIVE = 'outofstock_section/outofstock_grp/active';
	/**
	* @var \Magento\Framework\Mail\Template\TransportBuilder
	*/
	protected $_transportBuilder;

	/**
	* @var \Magento\Framework\Translate\Inline\StateInterface
	*/
	protected $inlineTranslation;

	/**
	* @var \Magento\Framework\App\Config\ScopeConfigInterface
	*/
	protected $scopeConfig;

	/**
	* @var \Magento\Store\Model\StoreManagerInterface
	*/
	protected $storeManager; 
	/**
	* @var \Magento\Framework\Escaper
	*/
	protected $_escaper;
	protected $baseurl;
	/**
	* @param \Magento\Framework\App\Action\Context $context
	* @param \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
	* @param \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation
	* @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
	* @param \Magento\Store\Model\StoreManagerInterface $storeManager
	*/
	public function __construct(
		\Magento\Framework\App\Helper\Context $context,
		\Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
		\Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
		\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
		\Magento\Store\Model\StoreManagerInterface $storeManager,
		\Magento\Framework\Escaper $escaper,
		\Magento\Store\Model\StoreManagerInterface $baseurl
		) {
		parent::__construct($context);
		$this->_transportBuilder = $transportBuilder;
		$this->inlineTranslation = $inlineTranslation;
		$this->scopeConfig = $scopeConfig;
		$this->storeManager = $storeManager;
		$this->_escaper = $escaper;
		$this->baseurl = $baseurl;
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

	/**
	* Post user question
	*
	* @return void
	* @throws \Exception
	*/
	public function sendEmail($email,$product)
	{
		// $post = null;
		$post['product_name'] = $product->getName();
		$post['product_url'] = $this->baseurl->getStore()->getBaseUrl().$product->getUrlKey().'.html';

				
		// if (!$post) {
		// 	$this->_redirect('*/*/');
		// 	return;
		// }

		$this->inlineTranslation->suspend();
		try {
			$postObject = new \Magento\Framework\DataObject();
			$postObject->setData($post);

			$error = false;


			$sender = [
				'name' => $this->getStoreConfig('trans_email/ident_general/name'),
				'email' => $this->getStoreConfig('trans_email/ident_general/email')
			];

			$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE; 
			$transport = $this->_transportBuilder
			->setTemplateIdentifier('outofstock_section_outofstock_grp_show_email') // this code we have mentioned in the email_templates.xml
			->setTemplateOptions(
				[
				'area' => \Magento\Framework\App\Area::AREA_FRONTEND, // this is using frontend area to get the template file
				'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
				]
			)
			->setTemplateVars(['data' => $postObject])
			->setFrom($sender)
			->addTo($email)
			->getTransport();

			$transport->sendMessage();
			$this->inlineTranslation->resume();
			/*$this->messageManager->addSuccess(
			__('Thanks for contacting us with your comments and questions. We\'ll respond to you very soon.')
			);*/
			// $this->_redirect('*/*/');
			return;
		} catch (\Exception $e) {
			$this->inlineTranslation->resume();
			// $this->messageManager->addError(
			// __('We can\'t process your request right now. Sorry, that\'s all we know.'.$e->getMessage())
			// );
			// $this->_redirect('*/*/');
			return;
		}
	}
}