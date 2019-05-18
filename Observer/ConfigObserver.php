<?php
namespace Lumio\Analytics\Observer;

use Magento\Framework\Event\ObserverInterface;

use \Lumio\Analytics\Helper\Data;

class ConfigObserver implements ObserverInterface
{
    /**
     * @param \Lumio\Analytics\Helper\Data $helper
     */
    public function __construct(
        Data $helper
    ) {
        $this->helper = $helper;
    }
    /**
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $changedPaths = $observer->getEvent()->getData('changed_paths');
        if (\array_intersect([
            Data::XML_MODULE_PATH . 'key',
            Data::XML_MODULE_PATH . 'active',
        ], $changedPaths)) {
            $active = $this->helper->getConfigData('active');
            $key = $this->helper->getConfigData('key');
            if ($active && !$this->helper->isValidKey($key)) {
                throw new \Magento\Framework\Exception\ValidatorException(__('Lumio Tracking key is not valid.'));
            }
            if (!$this->helper->registerIntegration($key, $active)) {
                throw new \Magento\Framework\Exception\ValidatorException(__('Error registering the integration.'));
            }
        }

        return $this;
    }
}
