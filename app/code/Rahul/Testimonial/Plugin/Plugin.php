<?php
     
namespace Rahul\Testimonial\Plugin;

use Magento\Framework\App\Response\Http as responseHttp;
use Magento\Framework\UrlInterface;

class Plugin
{

    protected $helper;
    protected $response;
    protected $_url;

    public function __construct(
     \Rahul\Testimonial\Helper\Data $helper,
     responseHttp $response,
     UrlInterface $url
     ) {
        $this->helper = $helper;
        $this->response = $response;
        $this->_url = $url;
    }

    public function beforeDispatch(\Magento\Framework\App\ActionInterface $subject, \Magento\Framework\App\RequestInterface $request)
    {
        // echo "asdasd";exit;
        if(!$this->helper->checkModule()){
            // echo "false";exit;

             $url = $this->_url->getUrl();
             $this->response->setRedirect($url);
             return $result;
        }
    }
}
