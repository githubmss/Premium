<?php
namespace Magentomobileshop\Premium\Observer;

use \Magento\Framework\Event\Observer;
use \Magento\Framework\Event\ObserverInterface;

class ControllerActionPredispatch implements ObserverInterface
{
    private $resultPageFactory;

    public function __construct(
        \Magento\Catalog\Helper\Category $category,
        \Magento\Catalog\Model\CategoryRepository $categoryRepository
    ) {
        $this->category           = $category;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Unset getdashboard api response
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $observerResponse = $observer->getData('mss_dashboard');
        $categories       = $this->category->getStoreCategories();
        $finalResult      = $observerResponse->getData();
        foreach ($categories as $category) {
            $categoryObj = $this->categoryRepository->get($category->getId());
            if ($categoryObj->getMssAttribute() && $categoryObj->getMssImage()) {
                $objectData = \Magento\Framework\App\ObjectManager::getInstance();
                $mediaUrl      = $objectData->get('Magento\Store\Model\StoreManagerInterface')
                    ->getStore()
                    ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
                $finalResult[] = [
                    'type'          => 'premium_category',
                    'category_icon' => $mediaUrl . "catalog/category/" . $categoryObj->getMssImage(),
                    'category_id'   => $categoryObj->getId(),
                    'category_name' => $categoryObj->getName(),
                ];
            }
        }

        $observerResponse->setData($finalResult);
        return $this;
    }
}
