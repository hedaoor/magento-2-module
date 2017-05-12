<?php

namespace Rahul\Testimonial\Controller\Adminhtml\Testimonial;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Rahul\Testimonial\Model\ResourceModel\Testimonial\CollectionFactory;
use Magento\Backend\App\Action;

class MassDisable extends Action
{
    /**
    * @var CollectionFactory
    */
    protected $collectionFactory;
    /**
    * @param Context $context
    * @param Filter $filter
    * @param CollectionFactory $collectionFactory*/

    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory)
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
    * Execute action
    *
    * @return \Magento\Backend\Model\View\Result\Redirect
    */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();
        $disable = 0;
        foreach ($collection as $item) {
            if($item->getIsActive() == 1){
                $item->setIsActive(0)->save();
                $disable++;
            }
        }
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been disable.', $disable));
        /** @var \Magento\Backend\Model\View\Result\Redirect
        $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
