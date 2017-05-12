<?php

namespace Rahul\Testimonial\Controller\Index;

use Magento\Framework\Controller\ResultFactory;

class Save extends \Magento\Framework\App\Action\Action
{
	protected $Testimonial;
    protected $date;
    protected $_messageManager;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
        \Rahul\Testimonial\Model\Testimonial $Testimonial,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Framework\Message\ManagerInterface $messageManager
	){
		$this->Testimonial = $Testimonial;
        $this->date = $date;
        $this->_messageManager = $messageManager;
        parent::__construct($context);
	}

    public function execute()
    {
        $data = $this->getRequest()->getParams();
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
    	$Testimonial = $this->Testimonial;
        try{

        	if($Testimonial->saveTestimonial($data,$Testimonial)){
                $this->messageManager->addSuccess(__('You saved this Testimonial.'));
            }
            else{
                $this->messageManager->addError(__('Something went wrong unable to save testimonial'));
            }

        }
        catch(\Magento\Framework\Exception\LocalizedException $e){
            $this->messageManager->addError($e->getMessage());
        }
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        return $resultRedirect;
    }
}