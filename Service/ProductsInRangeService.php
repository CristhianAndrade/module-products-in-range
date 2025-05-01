<?php
/**
 * @author Cristhian Andrade
 * @copyright 2025 GPL3
 * @license GPL-3.0
 */

declare(strict_types=1);

namespace CrimsonAgility\ProductsInRange\Service;

use CrimsonAgility\ProductsInRange\Api\ProductsInRangeServiceInterface;
use CrimsonAgility\ProductsInRange\Model\ProductsInRangeRepository;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use Magento\Framework\Api\SortOrderBuilder;

/**
 * Class to define ProductsInRange Service
 */
class ProductsInRangeService implements ProductsInRangeServiceInterface
{
    /** @var ProductsInRangeRepository */
    protected ProductsInRangeRepository $productsInRangeRepository;

    /** @var SearchCriteriaBuilder */
    protected SearchCriteriaBuilder $searchCriteriaBuilder;

    /** @var FilterBuilder */
    protected FilterBuilder $filterBuilder;

    /** @var FilterGroupBuilder */
    protected FilterGroupBuilder $filterGroupBuilder;

    /** @var SortOrderBuilder */
    protected SortOrderBuilder $sortOrderBuilder;

    /**
     * Constructor method
     *
     * @param ProductsInRangeRepository $productsInRangeRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param FilterBuilder $filterBuilder
     * @param FilterGroupBuilder $filterGroupBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     */
    public function __construct(
        ProductsInRangeRepository $productsInRangeRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder,
        FilterGroupBuilder $filterGroupBuilder,
        SortOrderBuilder $sortOrderBuilder
    ) {
        $this->productsInRangeRepository = $productsInRangeRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterGroupBuilder = $filterGroupBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
    }

    /**
     * Set search criteria and load products
     *
     * @param array $data
     * @return array
     */
    public function getProductsByList(array $data, bool $json = false): array
    {
        $searchCriteria = $this->searchCriteriaBuilder->create();

        $filter[] = $this->filterBuilder
            ->setField('price')
            ->setValue((float)$data['low_range'])
            ->setConditionType('gteq')
            ->create();

        $filter[] = $this->filterBuilder
            ->setField('price')
            ->setValue((float)$data['high_range'])
            ->setConditionType('lteq')
            ->create();

        $criteria[] = $this->filterGroupBuilder
            ->addFilter($filter[0])
            ->create();

        $criteria[] = $this->filterGroupBuilder
            ->addFilter($filter[1])
            ->create();

        $sortOrder = $this->sortOrderBuilder
            ->setField('price')
            ->setDirection(strtoupper($data['sort_by']))
            ->create();

        $searchCriteria->setFilterGroups($criteria);
        $searchCriteria->setSortOrders([$sortOrder]);
        $searchCriteria->setPageSize(10);

        $productsInRange = $this->productsInRangeRepository->getList($searchCriteria);

        if (!$json) {
            return $productsInRange->getItems();
        }

        $products = [];

        foreach ($productsInRange->getItems() as $product) {
            $products[] = $product->getData();
        }

        return $products;
    }

}
