<?php
/**
 * @author Cristhian Andrade
 * @copyright 2025 GPL3
 * @license GPL-3.0
 */

declare(strict_types=1);

namespace CrimsonAgility\ProductsInRange\Api;

/**
 * Interface to set method for ProductsInRage Service
 */
interface ProductsInRangeServiceInterface
{
    /**
     * Get products by list.
     *
     * @param array $data
     * @return array
     */
    public function getProductsByList(array $data, bool $json = false): array;
}
