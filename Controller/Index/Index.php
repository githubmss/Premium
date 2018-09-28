<?php

namespace Magentomobileshop\Premium\Controller\Index;

use Magento\Framework\App\Action\Context;

class Index extends \Magento\Framework\App\Action\Action
{
    private $resultPageFactory;

    public function __construct(
        Context $context,
        \Magento\Catalog\Helper\Category $category,
        \Magento\Catalog\Model\CategoryRepository $categoryRepository,
        \Magentomobileshop\Connector\Helper\Data $customHelper,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    ) {
        $this->category           = $category;
        $this->categoryRepository = $categoryRepository;
        $this->resultJsonFactory  = $resultJsonFactory;
        $this->customHelper       = $customHelper;
        parent::__construct($context);
    }

    public function execute()
    {
        $this->customHelper->loadParent($this->getRequest()->getHeader('token'));
        $categories  = $this->category->getStoreCategories();
        $resultArray = [];
        foreach ($categories as $category) {
            $categoryObj = $this->categoryRepository->get($category->getId());
            if ($categoryObj->getMssAttribute() && $categoryObj->getMssImage()) {
                $objectData = \Magento\Framework\App\ObjectManager::getInstance();
                $mediaUrl   = $objectData->get('Magento\Store\Model\StoreManagerInterface')
                    ->getStore()
                    ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
                $resultArray[] = [
                    'category_icon' => $mediaUrl . "catalog/category/" . $categoryObj->getMssImage(),
                    'id'            => $categoryObj->getId(),
                    'title'         => $categoryObj->getName(),
                ];
            }
        }

        $result = $this->resultJsonFactory->create();
        $result->setData(['status' => 'success', 'data' => $resultArray]);
        return $result;
    }
}
