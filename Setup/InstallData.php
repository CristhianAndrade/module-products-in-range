<?php
/**
 * @author Cristhian Andrade
 * @copyright 2025 GPL3
 * @license GPL-3.0
 */

declare(strict_types=1);

namespace CrimsonAgility\ProductsInRange\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use CrimsonAgility\ProductsInRange\Model\ProductsInRangeFactory;
use CrimsonAgility\ProductsInRange\Model\ProductsInRangeRepository;

/**
 * Class to fill example data in database
 */
class InstallData implements InstallDataInterface
{
    /** @var ProductsInRangeFactory */
    protected ProductsInRangeFactory $productsInRangeFactory;

    /** @var ProductsInRangeRepository */
    protected ProductsInRangeRepository $productsInRangeRepository;

    /**
     * Constructor Method
     *
     * @param ProductsInRangeFactory $productsInRangeFactory
     * @param ProductsInRangeRepository $productsInRangeRepository
     */
    public function __construct(
        ProductsInRangeFactory $productsInRangeFactory,
        ProductsInRangeRepository $productsInRangeRepository
    ) {
        $this->productsInRangeFactory = $productsInRangeFactory;
        $this->productsInRangeRepository = $productsInRangeRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $data = [
                'name' => 'Product-',
                'thumbnail' => null,
                'sku' => "",
                'price' => 1,
                'qty' => 0,
                'link' => 'https://example.com/product-',
        ];

        for ($i = 1; $i <= 10; $i++) {
            $this->createObject($data, $i);
            $this->createObject($data, $i);
        }

        $setup->endSetup();
    }

    /**
     * Create Object method
     *
     * @param array $data
     * @return void
     */
    protected function createObject(array $data, int $i): void
    {
        $productInRange = $this->productsInRangeFactory->create();
        $productInRange->setName($data['name'].$i);
        $productInRange->setThumbnail($data['thumbnail']);
        $productInRange->setSku($data['sku'].uniqid());
        $productInRange->setPrice((float)number_format($data['price'] + ($i*100), 2, '.', ''));
        $productInRange->setQty($data['qty'] + $i);
        $productInRange->setLink($data['link'].$i);

        $this->productsInRangeRepository->save($productInRange);
    }
}
