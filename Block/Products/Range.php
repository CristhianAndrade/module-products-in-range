<?php
/**
 * @author Cristhian Andrade
 * @copyright 2025 GPL3
 * @license GPL-3.0
 */

declare(strict_types=1);

namespace CrimsonAgility\ProductsInRange\Block\Products;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use CrimsonAgility\ProductsInRange\Model\Source\ProductsInRangeSortByPriceOptions;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Directory\Model\Currency;

/**
 * Class to set block
 */
class Range extends Template
{
    /** @var ProductsInRangeSortByPriceOptions */
    protected ProductsInRangeSortByPriceOptions $options;

    /** @var StoreManagerInterface */
    protected StoreManagerInterface $storeManager;

    /** @var Currency */
    protected Currency $currency;

    /**
     * Constructor method
     *
     * @param Context $context
     * @param ProductsInRangeSortByPriceOptions $options
     * @param StoreManagerInterface $storeManager
     * @param Currency $currency
     * @param array $data
     */
    public function __construct(
        Context $context,
        ProductsInRangeSortByPriceOptions $options,
        StoreManagerInterface $storeManager,
        Currency $currency,
        array $data = []
    ) {
        $this->options = $options;
        $this->storeManager = $storeManager;
        $this->currency = $currency;
        parent::__construct($context, $data);
    }

    /**
     * Return sort by price options
     *
     * @return array
     */
    public function getSortByPriceOptions(): array
    {
        return $this->options->toOptionArray();
    }

    /**
     * Method to get the current currency code
     *
     * @return string
     * @throws NoSuchEntityException
     */
    protected function getCurrentCurrencyCode(): string
    {
        return $this->storeManager->getStore()->getCurrentCurrencyCode();
    }

    /**
     * Method to get the current currency symbol
     *
     * @return string
     * @throws NoSuchEntityException
     */
    public function getCurrentCurrencySymbol(): string
    {
        return $this->currency->load($this->getCurrentCurrencyCode())->getCurrencySymbol();
    }
}
