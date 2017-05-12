<?php

namespace Rahul\Outofstock\Ui\Component\Listing\Column;

class Active extends \Magento\Ui\Component\Listing\Columns\Column {

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
        array $components = [],
        array $data = []
    ){
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
               if ($item['is_active'] == 1) {
                    $item['is_active'] = 'Enable';
               }
               else{
                    $item['is_active'] = 'Disable';
               }    
            }
        }

        return $dataSource;
    }
}