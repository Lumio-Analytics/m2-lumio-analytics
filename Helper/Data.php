<?php
 
namespace Lumio\Analytics\Helper;
 
class Data extends \Magento\Framework\App\Helper\AbstractHelper {

    const MODULE_NAME = 'Lumio_Analytics';
    const XML_MODULE_PATH = 'lumio/analytics/';
    
    /**
    * @var \Magento\Framework\App\Config\ScopeConfigInterface
    */
    protected $scopeConfig;
 
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\App\ProductMetadataInterface $productMetadata,
        \Magento\Framework\Module\ModuleListInterface $moduleList,
        \Magento\Framework\UrlInterface $urlBuilder
    ) {
        $this->scopeConfig     = $scopeConfig;
        $this->productMetadata = $productMetadata;
        $this->moduleList      = $moduleList;
        $this->urlBuilder      = $urlBuilder;
    }
 
    /**
    * function returning config value
    */
    public function getConfigData($key)
    {
        return $this->scopeConfig->getValue(self::XML_MODULE_PATH . $key);
    }

    /**
     * Check if it is a valid key
     *
     * @param string $key key to check.
     * @return boolean
     */
    public function isValidKey($key = null)
    {
        $key = $key ? $key : $this->getConfigData('key');
        return preg_match('/^\w{40}$/', $key);
    }

    /**
     * Send registration to the API
     *
     * @param boolean $is_active Activate or deactivate.
     * @return void
     */
    public function registerIntegration($key = null, $is_active = true)
    {
        $key = $key ? $key : $this->getConfigData('key');
        $client      = new \Lumio\IntegrationAPI\Client();
        $integration = new \Lumio\IntegrationAPI\Model\Integration(
            array(
                'key'              => $key,
                'url'              => $this->urlBuilder->getUrl('/'),
                'platform'         => 'Magento 2',
                'platform_version' => $this->productMetadata->getVersion(),
                'plugin'           => self::MODULE_NAME,
                'plugin_version'   => $this->getVersion(),
                'status'           => $is_active,
            )
        );
        try {
            $result = $client->registerIntegration($integration);
        } catch (Exception $e) {
            //echo 'Exception when calling AdminsApi->getAll: ', $e->getMessage(), PHP_EOL;
            return false;
        }
        return true;
    }

    public function getVersion()
    {
        return $this->moduleList
            ->getOne(self::MODULE_NAME)['setup_version'];
    }

    public function isLumioAnalyticsAvailable()
    {
        return $this->getConfigData('active') &&
        $this->isValidKey();
    }
}
