<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Rahul\Wishlist\Block\Product;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Collection\AbstractCollection;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\DataObject\IdentityInterface;

/**
 * Product list
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class ListProduct extends \Magento\Catalog\Block\Product\ListProduct
{
    protected $_helper;
    protected $_customerUrl;
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Data\Helper\PostHelper $postDataHelper,
        \Magento\Catalog\Model\Layer\Resolver $layerResolver,
        CategoryRepositoryInterface $categoryRepository,
        \Magento\Framework\Url\Helper\Data $urlHelper,
        \Rahul\Wishlist\Helper\Data $helper,
        \Magento\Customer\Model\Url $customerUrl
    ){
        $this->_helper = $helper;
        $this->_customerUrl = $customerUrl;
        parent::__construct($context,$postDataHelper,$layerResolver,$categoryRepository,$urlHelper);
    }

    public function isEnable()
    {
        return $this->_helper->isEnable();   
    }

    public function getLoginUrl(){
        return $this->_customerUrl->getLoginUrl();
    }
}
