<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Rahul\Wishlist\Controller\Rewrite\Index;

use Magento\Framework\Controller\ResultFactory;  

// use Magento\Catalog\Api\ProductRepositoryInterface;
// use Magento\Framework\App\Action;
// use Magento\Framework\Data\Form\FormKey\Validator;
// use Magento\Framework\Exception\NotFoundException;
// use Magento\Framework\Exception\NoSuchEntityException;
// use Magento\Framework\Controller\ResultFactory;
/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Add extends \Magento\Wishlist\Controller\Index\Add
{
    protected $resultFactory1;
    protected $resultJsonFactory ;

    public function execute()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $helper = $objectManager->create('Rahul\Wishlist\Helper\Data')->isEnable();
        // parent::execute();
        if($helper){
            $wishlist = $this->wishlistProvider->getWishlist();
            if (!$wishlist) {
                throw new NotFoundException(__('Page not found.'));
            }

            $session = $this->_customerSession;

            if(!$session->isLoggedIn()) {
                $storeManager= $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
                $url = $storeManager->getStore()->getUrl('customer/account/login');
                $array = array('status' => 'not_logged_in','msg' => 'Please login to add product wi wishlist','redirect' => $url);
                $jsonData = json_encode($array);
                $this->getResponse()->setHeader('Content-type', 'application/json');
                $this->getResponse()->setBody($jsonData);
                return;
            }
            
            $requestParams = $this->getRequest()->getParams();

            if ($session->getBeforeWishlistRequest()) {
                $requestParams = $session->getBeforeWishlistRequest();
                $session->unsBeforeWishlistRequest();
            }

            $productId = isset($requestParams['product']['product']) ? (int)$requestParams['product']['product'] : null;
            // $productId  = 0;
            if (!$productId) {
                $array = array('status' => 'error','msg' => 'Product not found');
                $jsonData = json_encode($array);
                $this->getResponse()->setHeader('Content-type', 'application/json');
                $this->getResponse()->setBody($jsonData);
                return;
            }

            try {
                $product = $this->productRepository->getById($productId);
            } catch (NoSuchEntityException $e) {
                $product = null;
            }

            if (!$product || !$product->isVisibleInCatalog()) {
                $array = array('status' => 'error','msg' => 'Product is not visible in catalog');
                $jsonData = json_encode($array);
                $this->getResponse()->setHeader('Content-type', 'application/json');
                $this->getResponse()->setBody($jsonData);
                return;   
            }

            try {
                $buyRequest = new \Magento\Framework\DataObject($requestParams['product']);

                $result = $wishlist->addNewItem($product, $buyRequest);
                if (is_string($result)) {
                    throw new \Magento\Framework\Exception\LocalizedException(__($result));
                }
                $wishlist->save();

                $this->_eventManager->dispatch(
                    'wishlist_add_product',
                    ['wishlist' => $wishlist, 'product' => $product, 'item' => $result]
                );

                $referer = $session->getBeforeWishlistUrl();
                if ($referer) {
                    $session->setBeforeWishlistUrl(null);
                } else {
                    $referer = $this->_redirect->getRefererUrl();
                }

                $this->_objectManager->get('Magento\Wishlist\Helper\Data')->calculate();

                $this->messageManager->addComplexSuccessMessage(
                    'addProductSuccessMessage',
                    [
                        'product_name' => $product->getName(),
                        'referer' => $referer
                    ]
                );

                $array = array('status' => 'success','msg' => $product->getName().' added to wishlist');
                $jsonData = json_encode($array);
                $this->getResponse()->setHeader('Content-type', 'application/json');
                $this->getResponse()->setBody($jsonData);
                return;   
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addErrorMessage(
                    __('We can\'t add the item to Wish List right now: %1.', $e->getMessage())
                );
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage(
                    $e,
                    __('We can\'t add the item to Wish List right now.')
                );
            }    
        }
        else{
            return parent::execute();
        }   
    }
}
