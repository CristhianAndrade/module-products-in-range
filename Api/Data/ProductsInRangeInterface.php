<?php
/**
 * @author Cristhian Andrade
 * @copyright 2025 GPL3
 * @license GPL-3.0
 */

declare(strict_types=1);

namespace CrimsonAgility\ProductsInRange\Api\Data;

/**
 * Interface ProductsInRang to define methods
 */
interface ProductsInRangeInterface
{
    const string ENTITY_ID = 'entity_id';
    const string SKU = 'sku';
    const string PRICE = 'price';
    const string QTY = 'qty';
    const string NAME = 'name';
    const string LINK = 'link';
    const string THUMBNAIL = 'thumbnail';

    /**
     * Get sku
     *
     * @return string
     */

    public function getSku(): string;

    /**
     * Set sku
     *
     * @param string $sku
     * @return $this
     */
    public function setSku(string $sku): self;

    /**
     * Get price
     *
     * @return float
     */

    public function getPrice(): float;

    /**
     * Set price
     *
     * @param float $price
     * @return $this
     */

    public function setPrice(float $price): self;

    /**
     * Get qty
     *
     * @return int
     */

    public function getQty(): int;

    /**
     * Set qty
     * @param int $qty
     * @return $this
     */

    public function setQty(int $qty): self;

    /**
     * Get name
     *
     * @return string
     */

    public function getName(): string;

    /**
     * Set name
     *
     * @param string $name
     * @return $this
     */

    public function setName(string $name): self;

    /**
     * Get link
     *
     * @return string|null
     */

    public function getLink(): ?string;

    /**
     * Set name
     *
     * @param string $link
     * @return $this
     */

    public function setLink(string $link): self;

    /**
     * Get thumbnail
     *
     * @return string|null
     */

    public function getThumbnail(): ?string;

    /**
     * Set thumbnail
     *
     * @param string $thumbnail
     * @return $this
     */
    public function setThumbnail(string $thumbnail): self;
}
