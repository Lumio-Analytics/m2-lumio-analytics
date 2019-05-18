<?php
namespace Lumio\Analytics\Controller\Adminhtml\Panel;

use Magento\Framework\Controller\ResultFactory;

class Index extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Lumio_Analytics::panel';

    private $resultPageFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Lumio\Analytics\Helper\Data $helper
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->helper = $helper;
        $this->resultRedirect = $context->getResultFactory();
        parent::__construct($context);
    }

    /**
     * Index action list city.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        if (! $this->helper->getConfigData('active') ||
            ! $this->helper->isValidKey()) {
            $resultRedirect = $this->resultRedirect->create(ResultFactory::TYPE_REDIRECT);
            return $resultRedirect->setPath('adminhtml/system_config/edit/section/lumio');
        }
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->addBreadcrumb(__('Lumio'), __('Panel'));
        $resultPage->getConfig()->getTitle()->prepend(__('Lumio Analytics'));

        return $resultPage;
    }

    /**
     * @return bool
     */
    public function _isAllowed()
    {
        return $this->_authorization->isAllowed(self::ADMIN_RESOURCE);
    }
}
