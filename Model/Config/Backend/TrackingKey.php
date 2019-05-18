<?php

namespace Lumio\Analitycs\Model\Config\Backend;

class TrackingKey extends \Magento\Framework\App\Config\Value
{
    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param ScopeConfigInterface $config
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Config\ScopeConfigInterface $config,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Lumio\Analytics\Helper\Data $helper,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
        $this->helper = $helper;
    }

    public function beforeSave()
    {
        $label = $this->getData('field_config/label');
        if ($this->getValue() == '') {
            throw new \Magento\Framework\Exception\ValidatorException(__($label . ' is required.'));
        } elseif (!$this->helper->isValidKey($this->getValue())) {
            throw new \Magento\Framework\Exception\ValidatorException(__($label . ' is not valid.'));
        }
        if (!$this->helper->registerIntegration($key, true)) {
            throw new \Magento\Framework\Exception\ValidatorException(__('Error registering the integration.'));
        }
        $this->setValue(intval($this->getValue()));

        parent::beforeSave();
    }
}
