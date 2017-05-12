<?php
namespace Rahul\Testimonial\Model;
 
use Rahul\Testimonial\Model\ResourceModel\Testimonial\CollectionFactory;
 
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $testimonialCollectionFactory
     * @param array $meta
     * @param array $data
     */

    protected $_loadedData;
    protected $_storeManager;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $testimonialCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $testimonialCollectionFactory->create();
        $this->_storeManager = $storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }
 
    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $item) {
            // $this->_loadedData[$employee->getId()] = $employee->getData();

            $itemData = $item->getData();
            $imageName = $itemData['avtar']; // Your database field 
            if($imageName)
            {
                $imageUrl = $this ->_storeManager-> getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA ).$imageName;
                unset($itemData['avtar']);
                $itemData['avtar'] = array(
                    array(
                        'name'  =>  $imageName,
                        'url'   =>  $imageUrl 
                    )
                );
            }

            $this->_loadedData[$item->getId()] = $itemData;
        }
        return $this->_loadedData;
    }
}