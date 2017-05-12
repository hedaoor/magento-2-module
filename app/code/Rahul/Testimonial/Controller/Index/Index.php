<?php

namespace Rahul\Testimonial\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
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
    	$Testimonial = $this->Testimonial;
    			
        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();
    }
}