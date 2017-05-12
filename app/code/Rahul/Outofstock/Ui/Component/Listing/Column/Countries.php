<?php

namespace Rahul\Outofstock\Ui\Component\Listing\Column;

class Countries extends \Magento\Ui\Component\Listing\Columns\Column {

    /**
     * @var \Magento\Directory\Api\CountryInformationAcquirerInterface
     */
    protected $countryInformation;
    protected $_countryFactory;

     /**
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory
     * @param \Magento\Directory\Api\CountryInformationAcquirerInterface $countryInformation
     * @param array $components
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        \Magento\Directory\Model\CountryFactory $countryFactory,
        array $components = [],
        array $data = []
    ){
        $this->_countryFactory = $countryFactory;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource) {
        if (isset($dataSource['data']['items'])) {
                   
            foreach ($dataSource['data']['items'] as & $item) {
                $countryNames = [];
                $countryCodes = [];
                if($item['country_codes']){
                    $country = $this->_countryFactory->create()->loadByCode($item['country_codes']);
                    $item['country_codes'] = $country->getName();
                }
                    
            }
        }

        return $dataSource;
    }
}