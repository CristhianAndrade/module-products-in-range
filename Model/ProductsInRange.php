<?php
/**
 * @author Cristhian Andrade
 * @copyright 2025 GPL3
 * @license GPL-3.0
 */

declare(strict_types=1);

namespace CrimsonAgility\ProductsInRange\Model;

use CrimsonAgility\ProductsInRange\Api\Data\ProductsInRangeInterface;
use CrimsonAgility\ProductsInRange\Model\ResourceModel\ProductsInRange as ResourceProductsInRange;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;

/**
 * Class to define ProductsInRange model
 */
class ProductsInRange extends AbstractModel implements ProductsInRangeInterface
{
    /**
     * @inheritDoc
     * @throws LocalizedException
     */
    public function _construct(): void
    {
        $this->_init(ResourceProductsInRange::class);
    }

    /**
     * @inheritDoc
     */
    public function getSku(): string
    {
        return $this->getData(self::SKU);
    }

    /**
     * @inheritDoc
     */
    public function setSku(string $sku): self
    {
        return $this->setData(self::SKU, $sku);
    }

    /**
     * @inheritDoc
     */
    public function getPrice(): float
    {
        return (float) $this->getData(self::PRICE);
    }

    /**
     * @inheritDoc
     */
    public function setPrice(float $price): self
    {
        return $this->setData(self::PRICE, $price);
    }

    /**
     * @inheritDoc
     */
    public function getQty(): int
    {
        return (int) $this->getData(self::QTY);
    }

    /**
     * @inheritDoc
     */
    public function setQty(int $qty): self
    {
        return $this->setData(self::QTY, $qty);
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->getData(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function setName(string $name): self
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @inheritDoc
     */
    public function getLink(): ?string
    {
        return $this->getData(self::LINK);
    }

    /**
     * @inheritDoc
     */
    public function setLink(?string $link): self
    {
        return $this->setData(self::LINK, $link);
    }

    /**
     * @inheritDoc
     */
    public function getThumbnail(): ?string
    {
        return $this->getData(self::THUMBNAIL);
    }

    /**
     * @inheritDoc
     */
    public function setThumbnail(?string $thumbnail): self
    {
        return $this->setData(self::THUMBNAIL, $thumbnail);
    }
}
