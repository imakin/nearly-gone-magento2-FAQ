<?php

/**
 * MagePrince
 * Copyright (C) 2020 Mageprince <info@mageprince.com>
 *
 * @package Prince_Faq
 * @copyright Copyright (c) 2020 Mageprince (http://www.mageprince.com/)
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License,version 3 (GPL-3.0)
 * @author MagePrince <info@mageprince.com>
 */

namespace Prince\Faq\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    private $resultPageFactory;

    /**
     * @var \Prince\Faq\Helper\Data
     */
    protected $helper;

    /**
     * Index constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Prince\Faq\Helper\Data $helper
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Prince\Faq\Helper\Data $helper,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->helper = $helper;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $pageMainTitle = $resultPage->getLayout()->getBlock('page.main.title');
        $pageTitle = $this->helper->getConfig('faqtab/general/page_title');

        if ($pageMainTitle && $pageMainTitle instanceof \Magento\Theme\Block\Html\Title) {
            $pageMainTitle->setPageTitle($pageTitle);
        }

        if(!$this->helper->getConfig('faqtab/general/enable')) {
            $pageMainTitle->setPageTitle('FAQ Disabled');
            return $resultPage;
        }

        $metaTitleConfig = $this->helper->getConfig('faqtab/seo/meta_title');
        $metaKeywordsConfig = $this->helper->getConfig('faqtab/seo/meta_keywords');
        $metaDescriptionConfig = $this->helper->getConfig('faqtab/seo/meta_description');

        $resultPage->getConfig()->getTitle()->set($metaTitleConfig);
        $resultPage->getConfig()->setDescription($metaKeywordsConfig);
        $resultPage->getConfig()->setKeywords($metaDescriptionConfig);

        return $resultPage;
    }
}
