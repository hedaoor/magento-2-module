<?php

namespace Rahul\Testimonial\Controller\Adminhtml\Testimonial;

use Magento\Framework\Controller\ResultFactory;
 
class Save extends \Magento\Backend\App\Action
{
    protected $testimonial;
    protected $helper;
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry    $coreRegistry
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Rahul\Testimonial\Model\Testimonial $testimonial,
        \Rahul\Testimonial\Helper\Data $helper
    ) 
    {
        $this->testimonial = $testimonial;
        $this->helper = $helper;
        parent::__construct($context);
    }
    /**
     * Add New Row Form page.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        // echo $id = (int) $this->getRequest()->getParam('id');exit;
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $data = $this->getRequest()->getParams();
        		
        if($data){
            if($data['id']){
                $model = $this->testimonial->load($data['id']);
            }
            else{
                $model = $this->testimonial;    
            }        
            
            $model->setName($data['name']);
            $model->setEmail($data['email']);
            // $model->setContent($data['content']);
            $model->setWebsite($data['website']);
            $model->setCompany($data['company']);
            $model->setAddress($data['address']);
            $model->setTestimonial($data['testimonial']);

            $model->setAvtar($this->helper->getImagePath($data['avtar'][0]));
            $model->setIsActive($data['is_active']);

            if($data['id']){
                $model->setUpdateTime($model->getCurrentDate());
            }
            else{
                $model->setCreationTime($model->getCurrentDate());
            }
                    // echo '<pre>';
                    // print_r($data);
                    // print_r($model->getData());
                    // exit;
                    
            // $model->save();

            try {
                    $model->save();
                    $this->messageManager->addSuccess(__('You saved this Testimonial.'));
                    $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                    if ($this->getRequest()->getParam('back')) {
                        return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                    }
                    return $resultRedirect->setPath('*/*/');
                } catch (\Magento\Framework\Exception\LocalizedException $e) {
                    $this->messageManager->addError($e->getMessage());
                } catch (\RuntimeException $e) {
                    $this->messageManager->addError($e->getMessage());
                } catch (\Exception $e) {
                    $this->messageManager->addException($e, __('Something went wrong while saving the testimonial.'));
                }

                $this->_getSession()->setFormData($data);
                return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            }
        return $resultRedirect->setPath('*/*/');
       
    }
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Rahul_Testimonial::testimonial');
    }
}