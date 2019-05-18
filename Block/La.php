<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Lumio\Analytics\Block;

use Magento\Framework\App\ObjectManager;

/**
 * Lumio Page Block
 *
 * @api
 * @since 100.0.2
 */
class La extends \Magento\Framework\View\Element\Template
{
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Lumio\Analytics\Helper\Data $helper
     * @param array $data
     * @param \Magento\Cookie\Helper\Cookie|null $cookieHelper
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Lumio\Analytics\Helper\Data $helper,
        array $data = []
    ) {
        $this->helper = $helper;
        parent::__construct($context, $data);
    }

    /**
     * Get config
     *
     * @param string $path
     * @return mixed
     */
    public function getKey()
    {
        return $this->helper->getConfigData('key');
    }

    /**
     * Render LA tracking scripts
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (!$this->helper->isLumioAnalyticsAvailable()) {
            return '';
        }

        return parent::_toHtml();
    }
}
