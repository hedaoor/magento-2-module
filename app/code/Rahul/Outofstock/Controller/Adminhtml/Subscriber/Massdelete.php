<?php
namespace Rahul\Outofstock\Controller\Adminhtml\Subscriber;

use Magento\Framework\Controller\ResultFactory;
// use Magento\Catalog\Controller\Adminhtml\Product\Builder;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Rahul\Outofstock\Model\ResourceModel\Subscriber\CollectionFactory;
/**
 * Class MassDelete
 */
class MassDelete extends \Magento\Backend\App\Action
{
    /**
     * Massactions filter
     *
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param Context $context
     * @param Builder $productBuilder
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        // Builder $productBuilder,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }
    /**
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        
                      
        $Deleted = 0;
        foreach ($collection->getItems() as $record) {
            $record->delete();
            $Deleted++;
        }

        echo $Deleted;exit;
        $this->messageManager->addSuccess(
            __('A total of %1 record(s) have been deleted.', $Deleted)
        );

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('customgrid/*/index');
    }
}