<?php

namespace Rahul\Testimonial\Controller\Adminhtml\Testimonial;

use Magento\Framework\Controller\ResultFactory;
 
class News extends \Magento\Backend\App\Action
{
    protected $_coreRegistry;
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry    $coreRegistry
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry
    ) 
    {
        parent::__construct($context);
        $this->_coreRegistry = $coreRegistry;
    }
    /**
     * Add New Row Form page.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $rowId = (int) $this->getRequest()->getParam('id');
        $rowData = $this->_objectManager->create('Rahul\Testimonial\Model\Testimonial');
        if ($rowId) {
            $rowData = $rowData->load($rowId);
            $rowTitle = $rowData->getTitle();
            if (!$rowData->getId()) {
                $this->messageManager->addError(__('row data no longer exist.'));
                $this->_redirect('testimonial/testimonial/index');
                return;
            }
        }
 
        $this->_coreRegistry->register('testimonial', $rowData);
        // $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        // $title = $rowId ? __('Edit Testimonial ').$rowTitle : __('Add Testimonial');
        // $resultPage->getConfig()->getTitle()->prepend($title);
        // return $resultPage;

        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        return $resultPage;
    }
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Rahul_Testimonial::testimonial');
    }
}