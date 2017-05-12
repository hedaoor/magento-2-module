<?php

namespace Rahul\Outofstock\Controller\Index;
use Magento\Framework\Controller\ResultFactory; 

class Index extends \Magento\Framework\App\Action\Action
{
    protected $_subscriber;
    protected $date;
    protected $_messageManager;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Rahul\Outofstock\Model\Subscriber $subscriber,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Framework\Message\ManagerInterface $messageManager
    ) {
        $this->_subscriber = $subscriber;
        $this->date = $date;
        $this->_messageManager = $messageManager;
        parent::__construct($context);
    }

    public function execute()
    {
        $subscriber = $this->_subscriber;
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $product_id = $this->getRequest()->getPost('product_id');
        $email = $this->getRequest()->getPost('email');
               
        if($this->_subscriber->checkUserWithProduct($email,$product_id,$this->_subscriber)){
            if($product_id && $email){

                $subscriber->setEmail($email);
                $subscriber->setProductId($product_id);
                $subscriber->setProductId($product_id);
                $subscriber->setIsActive(1);
                $subscriber->setCreatedAt($this->date->gmtDate());
                
                try{
                    $subscriber->save();
                    if($subscriber->getId()){
                    }
                    else{
                        $this->_messageManager->addError(__("Error Message"));
                    }
                    
                    $this->_messageManager->addSuccess(__("Product added in notify me"));
                }   
                catch(Exception $e){
                    echo $e->getMessage();
                }
            }   
        }
                
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        return $resultRedirect;
    }
}