<?php
/**
 * @author Cristhian Andrade
 * @copyright 2025 GPL3
 * @license GPL-3.0
 */

declare(strict_types=1);

namespace CrimsonAgility\ProductsInRange\Controller\Products;

use CrimsonAgility\ProductsInRange\Api\ProductsInRangeServiceInterface;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\Result\Json;
use CrimsonAgility\ProductsInRange\Model\Validator\ProductsInRangeValidate;
use Magento\Customer\Model\Session;

/**
 * Class to set search products by range
 */
class Search implements HttpGetActionInterface
{
    /** @var JsonFactory */
    protected JsonFactory $jsonFactory;

    /** @var RequestInterface */
    protected RequestInterface $request;

    /** @var ProductsInRangeValidate */
    protected ProductsInRangeValidate $productsInRangeValidate;

    /** @var ProductsInRangeServiceInterface */
    protected ProductsInRangeServiceInterface $productsInRangeService;

    /** @var Session */
    protected Session $customerSession;

    /**
     * @param JsonFactory $jsonFactory
     * @param RequestInterface $request
     * @param ProductsInRangeValidate $productsInRangeValidate
     * @param ProductsInRangeServiceInterface $productsInRangeService
     * @param Session $customerSession
     */
    public function __construct(
        JsonFactory                     $jsonFactory,
        RequestInterface                $request,
        ProductsInRangeValidate         $productsInRangeValidate,
        ProductsInRangeServiceInterface $productsInRangeService,
        Session                         $customerSession,
    )
    {
        $this->jsonFactory = $jsonFactory;
        $this->request = $request;
        $this->productsInRangeValidate = $productsInRangeValidate;
        $this->productsInRangeService = $productsInRangeService;
        $this->customerSession = $customerSession;
    }

    /**
     * @return Json
     */
    public function execute(): Json
    {
        $resultJson = $this->jsonFactory->create();

        if (!$this->customerSession->isLoggedIn()) {
            return $resultJson->setData(
                [
                    'request' => [
                        'success' => 'false',
                        'messages' => [
                            __('The user must be logged in')
                        ]
                    ]
                ]
            );
        }

        $data = $this->loadParams();
        $result = $this->checkParams($data);
        $data['request'] = $result;

        if ($result['success'] === 'false') {
            return $resultJson->setData($data);
        }

        $data = $this->loadProductsData($data);

        return $resultJson->setData($data);
    }

    /**
     * Collect parameters
     *
     * @return array
     */
    protected function loadParams(): array
    {
        return [
            "sort_by" => $this->request->getParam("sort_by"),
            "low_range" => $this->request->getParam("low_range"),
            "high_range" => $this->request->getParam("high_range")
        ];
    }

    /**
     * Method to check product in range data
     *
     * @param array $data
     * @return array
     */
    protected function checkParams(array $data): array
    {
        if (empty($data['low_range']) || empty($data['high_range'])) {
            return [
                'success' => 'false',
                'messages' => [
                    __('Low Range and High Range are required')
                ]
            ];
        }

        $isValidLow = $this->productsInRangeValidate->isValid(
            [
                "field_value" => $data['low_range'],
                "field_name" => "Low Range"
            ]
        );

        $isValidHigh = $this->productsInRangeValidate->isValid(
            [
                "field_value" => $data['high_range'],
                "field_name" => "High Range",
                'compare_field_value' => $data['low_range']
            ]
        );

        if (!$isValidHigh || !$isValidLow) {
            $messages = [];

            foreach ($this->productsInRangeValidate->getMessages() as $message) {
                $messages[] = $message;
            }

            return [
                'success' => 'false',
                'messages' => $messages
            ];
        }

        return [
            'success' => 'true'
        ];
    }

    /**
     * Load product from params
     *
     * @param array $data
     * @return array
     */
    protected function loadProductsData(array $data): array
    {
        $data['products'] = $this->productsInRangeService->getProductsByList($data, true);
        return $data;
    }
}
