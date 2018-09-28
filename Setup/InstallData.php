<?php
namespace Magentomobileshop\Premium\Setup;

use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    /**
     * EAV setup factory.
     *
     * @var EavSetupFactory
     */
    private $eavSetupFactory;
    private $categorySetupFactory;

    /**
     * Init.
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory, \Magento
        \Catalog\Setup\CategorySetupFactory $categorySetupFactory)
    {
        $this->eavSetupFactory      = $eavSetupFactory;
        $this->categorySetupFactory = $categorySetupFactory;
    }
//@codingStandardsIgnoreStart
    /**
     * {@inheritdoc}
     *
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $setup    = $this->categorySetupFactory->create(['setup' => $setup]);
        $setup->addAttribute(\Magento\Catalog\Model\Category::ENTITY, 'mss_image', [
            'type'       => 'varchar',
            'label'      => 'Magento App Icon',
            'input'      => 'image',
            'backend'    => 'Magento\Catalog\Model\Category\Attribute\Backend\Image',
            'required'   => false,
            'sort_order' => 9,
            'global'     => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
            'group'      => 'Magento Mobile Shop',
        ]
        );
        $setup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'mss_attribute',
            [
                'type'       => 'int',
                'label'      => 'Enable Feature Category',
                'input'      => 'select',
                'source'     => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
                'required'   => false,
                'sort_order' => 30,
                'group'      => 'Magento Mobile Shop',
            ]
        );
    }//@codingStandardsIgnoreEnd
}
