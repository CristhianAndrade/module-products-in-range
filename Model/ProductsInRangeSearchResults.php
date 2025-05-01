<?php
/**
 * @author Cristhian Andrade
 * @copyright 2025 GPL3
 * @license GPL-3.0
 */

declare(strict_types=1);

namespace CrimsonAgility\ProductsInRange\Model;

use CrimsonAgility\ProductsInRange\Api\Data\ProductsInRangeSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

/**
 * Class to define ProductsInRangeSearchResults
 */
class ProductsInRangeSearchResults extends SearchResults implements ProductsInRangeSearchResultsInterface
{
    /**
     * @inerhitDoc
     */
    public function getItems(): array
    {
        return $this->_get(self::KEY_ITEMS) === null ? [] : $this->_get(self::KEY_ITEMS);
    }

    /**
     * @inerhitDoc
     */
    public function setItems(array $items): self
    {
        return $this->setData(self::KEY_ITEMS, $items);
    }

}
