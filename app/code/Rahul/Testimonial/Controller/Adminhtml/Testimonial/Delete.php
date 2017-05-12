<?php
namespace Rahul\Testimonial\Controller\Adminhtml\Testimonial;

use Magento\Framework\Controller\ResultFactory;
// use Magento\Catalog\Controller\Adminhtml\Product\Builder;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Rahul\Testimonial\Model\Testimonial;
/**
 * Class MassDelete
 */
class Delete extends \Magento\Backend\App\Action
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
        Testimonial $collectionFactory
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
        // $collection = $this->filter->getCollection($this->collectionFactory->create());
        $id = $this->getRequest()->getParam('id');
        $collection = $this->collectionFactory;
        if($id){
            $collection->load($id)->delete();
        }
                
        $this->messageManager->addSuccess(
            __('Record(s) have been deleted.')
        );

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('testimonial/*/index');
    }
}