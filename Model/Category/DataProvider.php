<?php
namespace Magentomobileshop\Premium\Model\Category;

class DataProvider extends \Magento\Catalog\Model\Category\DataProvider
{
	//@codingStandardsIgnoreStart
    protected function getFieldsMap()
    {
        $fields              = parent::getFieldsMap();
        $fields['content'][] = 'mss_image'; // custom image field
        return $fields;
    }//@codingStandardsIgnoreEnd
}
