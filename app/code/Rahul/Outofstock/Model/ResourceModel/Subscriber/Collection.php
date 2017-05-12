<?php

namespace  Rahul\Outofstock\Model\ResourceModel\Subscriber;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Rahul\Outofstock\Model\Subscriber', 'Rahul\Outofstock\Model\ResourceModel\Subscriber');
    }
}
?>