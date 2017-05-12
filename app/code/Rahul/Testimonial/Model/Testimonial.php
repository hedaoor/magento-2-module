<?php
namespace Rahul\Testimonial\Model;

use Magento\Framework\App\Filesystem\DirectoryList;

class Testimonial extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */

    protected $_fileUploaderFactory;
    protected $_filesystem;

    const PATH = 'Testimonial';
    public function __construct(
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Filesystem $filtesystem,
        \Magento\Framework\Registry $registry

        ) {

        $this->_fileUploaderFactory = $fileUploaderFactory;
        $this->_filesystem = $filtesystem;
        parent::__construct($context,$registry);
    }
    
    protected function _construct()
    {
        $this->_init('Rahul\Testimonial\Model\ResourceModel\Testimonial');
    }

    public function saveTestimonial($data,$model){
    	
    	$model->setData($data);
    	$model->setCreationTime($this->getCurrentDate());
    	$model->setIsActive(0);
    	try{
	    	$avtar = $this->uploadImage();
            $model->setAvtar(self::PATH.'/'.$avtar['file']);
                   
            $model->save();
	    	if ($model->getId()) {
	    		return $model->getId();
	    	}
    	}
    	catch(\Magento\Framework\Exception\LocalizedException $e){
    		$this->messageManager->addError($e->getMessage());
    	}
    }

    public function uploadImage(){
        $uploader = $this->_fileUploaderFactory->create(['fileId' => 'avtar']);
      
        $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);

        $uploader->setAllowRenameFiles(false);

        $uploader->setFilesDispersion(false);

        $path = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)

        ->getAbsolutePath('Testimonial/');

        $result = $uploader->save($path);
        return $result;
    }

    public function getCurrentDate(){
    	$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$objDate = $objectManager->create('Magento\Framework\Stdlib\DateTime\DateTime');
		return $objDate->gmtDate();
    }
}
?>