<?php
/**
 * @author Cristhian Andrade
 * @copyright 2025 GPL3
 * @license GPL-3.0
 */

declare(strict_types=1);

namespace CrimsonAgility\ProductsInRange\Controller\Products;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\RequestInterface;
use CrimsonAgility\ProductsInRange\Model\Validator\ProductsInRangeValidate;
use CrimsonAgility\ProductsInRange\Api\ProductsInRangeServiceInterface;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;

/**
 * Class to set route Range
 */
class Range implements HttpGetActionInterface
{
    /** @var PageFactory */
    protected PageFactory $resultPageFactory;

    /** @var RequestInterface */
    protected RequestInterface $request;

    /** @var ProductsInRangeValidate */
    protected ProductsInRangeValidate $productsInRangeValidate;

    /** @var ManagerInterface */
    protected ManagerInterface $messageManager;

    /** @var ProductsInRangeServiceInterface */
    protected ProductsInRangeServiceInterface $productsInRangeService;

    /** @var RedirectFactory */
    protected RedirectFactory $resultRedirectFactory;

    /** @var Session */
    protected Session $customerSession;

    /**
     * Constructor method
     *
     * @param PageFactory $resultPageFactory
     * @param RequestInterface $request
     * @param ProductsInRangeValidate $productsInRangeValidate
     * @param ManagerInterface $messageManager
     * @param ProductsInRangeServiceInterface $productsInRangeService
     * @param RedirectFactory $resultRedirectFactory
     * @param Session $customerSession
     */
    public function __construct(
        PageFactory             $resultPageFactory,
        RequestInterface        $request,
        ProductsInRangeValidate $productsInRangeValidate,
        ManagerInterface        $messageManager,
        ProductsInRangeServiceInterface  $productsInRangeService,
        RedirectFactory $resultRedirectFactory,
        Session $customerSession,
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->request = $request;
        $this->productsInRangeValidate = $productsInRangeValidate;
        $this->messageManager = $messageManager;
        $this->productsInRangeService = $productsInRangeService;
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->customerSession = $customerSession;
    }

    /**
     * Execute page view action
     *
     * @return ResultInterface|Redirect
     */
    public function execute(): ResultInterface|Redirect
    {
        if (!$this->customerSession->isLoggedIn()) {
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('customer/account/login');
            return $resultRedirect;
        }

        $data = $this->loadParams();
        $result = $this->checkParams($data);

        if($result) {
            $data = $this->loadProductsData($data);
        }

        $page = $this->resultPageFactory->create();
        $page->getLayout()
            ->getBlock('crimson_agility.products_in_range.products.range')
            ->setData($data);
        return $page;
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
     * @return bool
     */
    protected function checkParams(array $data): bool
    {
        if (empty($data['low_range']) || empty($data['high_range'])) {
            return false;
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
            $this->addErrorMessage($this->productsInRangeValidate->getMessages());
            return false;
        }

        return true;
    }

    /**
     * Send Error Message to frontend
     *
     * @param array $messages
     * @return void
     */
    protected function addErrorMessage(array $messages): void
    {
        foreach ($messages as $message) {
            $this->messageManager->addErrorMessage($message);
        }
    }

    /**
     * Load product from params
     *
     * @param array $data
     * @return array
     */
    protected function loadProductsData(array $data): array
    {
        $data['products'] = $this->productsInRangeService->getProductsByList($data);
        return $data;
    }
}
