<?php
namespace Rahul\Outofstock\Model;

class Subscriber extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    
    protected function _construct()
    {
        $this->_init('Rahul\Outofstock\Model\ResourceModel\Subscriber');
    }

    public function checkUserWithProduct($email,$productid,$model)
    {
        $model = $model->getCollection()
                       ->addFieldToFilter('email',$email)
                       ->addFieldToFilter('product_id',$productid);
        
        $flag = false;
        if(empty($model->getData())){
            // echo "exit";
            $flag = true;
        }
        /*else{
            echo "new";
        }*/
        /*echo $flag;
        exit;*/
        return $flag;   
    }
}
?>