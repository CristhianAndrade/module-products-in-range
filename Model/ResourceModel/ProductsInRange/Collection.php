<?php
/**
 * @author Cristhian Andrade
 * @copyright 2025 GPL3
 * @license GPL-3.0
 */

declare(strict_types=1);

namespace CrimsonAgility\ProductsInRange\Model\ResourceModel\ProductsInRange;

use CrimsonAgility\ProductsInRange\Model\ProductsInRange;
use CrimsonAgility\ProductsInRange\Model\ResourceModel\ProductsInRange as ResourceProductsInRange;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class to set Collection for ProductsInRange
 */
class Collection extends AbstractCollection
{
    /** @inheritDoc */
    protected $_idFieldName = 'entity_id';

    /** @inheritDoc */
    protected function _construct(): void
    {
        $this->_init(
            ProductsInRange::class,
            ResourceProductsInRange::class
        );
    }
}
