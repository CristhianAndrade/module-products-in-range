<?php
/**
 * @author Cristhian Andrade
 * @copyright 2025 GPL3
 * @license GPL-3.0
 */

declare(strict_types=1);

namespace CrimsonAgility\ProductsInRange\Model;

use CrimsonAgility\ProductsInRange\Api\Data\ProductsInRangeInterface;
use CrimsonAgility\ProductsInRange\Api\Data\ProductsInRangeSearchResultsInterface;
use CrimsonAgility\ProductsInRange\Api\Data\ProductsInRangeSearchResultsInterfaceFactory;
use CrimsonAgility\ProductsInRange\Api\ProductsInRangeRepositoryInterface;
use CrimsonAgility\ProductsInRange\Model\ResourceModel\ProductsInRange\CollectionFactory as ProductsInRangeCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use CrimsonAgility\ProductsInRange\Model\ResourceModel\ProductsInRange as ResourceProductsInRange;
use Magento\Framework\Exception\CouldNotSaveException;

/**
 * Class to create repository for ProductsInRange
 */
class ProductsInRangeRepository implements ProductsInRangeRepositoryInterface
{
    /**
     * @var ProductsInRangeSearchResultsInterfaceFactory
     */
    protected ProductsInRangeSearchResultsInterfaceFactory $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected CollectionProcessorInterface $collectionProcessor;

    /**
     * @var ProductsInRangeCollectionFactory
     */
    protected ProductsInRangeCollectionFactory $productsInRangeCollectionFactory;

    /**
     * @var ResourceProductsInRange
     */
    protected ResourceProductsInRange $resource;

    /**
     * Constructor Method
     *
     * @param ResourceProductsInRange $resource
     * @param ProductsInRangeCollectionFactory $productsInRangeCollectionFactory
     * @param ProductsInRangeSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceProductsInRange $resource,
        ProductsInRangeCollectionFactory $productsInRangeCollectionFactory,
        ProductsInRangeSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->productsInRangeCollectionFactory = $productsInRangeCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->resource = $resource;
    }

    /**
     * @inheritDoc
     */
    public function save(
        ProductsInRangeInterface $productsInRange
    ): ProductsInRangeInterface {
        try {
            $this->resource->save($productsInRange);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the object, model ProductsInRange: %1',
                $exception->getMessage()
            ));
        }
        return $productsInRange;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        SearchCriteriaInterface $searchCriteria
    ): ProductsInRangeSearchResultsInterface {
        $collection = $this->productsInRangeCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
}
