<?php

namespace  Rahul\Testimonial\Model\ResourceModel\Testimonial;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'id';
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Rahul\Testimonial\Model\Testimonial', 'Rahul\Testimonial\Model\ResourceModel\Testimonial');
    }
}
?>