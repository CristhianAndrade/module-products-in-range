<?php
/**
 * @author Cristhian Andrade
 * @copyright 2025 GPL3
 * @license GPL-3.0
 */

declare(strict_types=1);

namespace CrimsonAgility\ProductsInRange\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use CrimsonAgility\ProductsInRange\Api\Data\ProductsInRangeSearchResultsInterface;
use CrimsonAgility\ProductsInRange\Api\Data\ProductsInRangeInterface;

/**
 * Interface to set methods for ProductsInRangeRepository
 */
interface ProductsInRangeRepositoryInterface
{
    /**
     * Save Object ProductsInRange
     *
     * @param ProductsInRangeInterface $productsInRange
     * @return ProductsInRangeInterface
     */
    public function save(
        ProductsInRangeInterface $productsInRange
    ): ProductsInRangeInterface;

    /**
     * Retrieve ProductsInRange matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return ProductsInRangeSearchResultsInterface
     */
    public function getList(
        SearchCriteriaInterface $searchCriteria
    ): ProductsInRangeSearchResultsInterface;
}
