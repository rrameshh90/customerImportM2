<?php
/**
 * @author Rameshkumar
 * @package WTC_CustomerImport
 */

declare(strict_types=1);

namespace WTC\CustomerImport\Model;

use Exception;
use WTC\CustomerImport\Helper\Data as HelperData;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Customer\Model\CustomerFactory;


class ImportCustomer
{

    /**
     * @var HelperData
     */
    protected HelperData $helper;
    /**
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $storeManager;

    /**
     * @var CustomerFactory
     */
    protected CustomerFactory $customerFactory;


    /**
     * @param HelperData $data
     * @param StoreManagerInterface $storeManager
     * @param CustomerFactory $customerFactory
     *
     */
    public function __construct(
        HelperData $helper,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Customer\Model\CustomerFactory $customerFactory
    ) {
        $this->helper = $helper;
        $this->customerFactory = $customerFactory;
        $this->storeManager = $storeManager;
    }


    /**
     * @param $dataRow
     */
    public function createCustomer($dataRow)
    {
        try {
            $store = $this->storeManager->getStore();
            $websiteId = $this->storeManager->getStore()->getWebsiteId();
            $customer = $this->customerFactory->create();
            $customer->setWebsiteId($websiteId);
            $customer->loadByEmail($dataRow['emailaddress']);
            if (!$customer->getId()) {
                $customer->setWebsiteId($websiteId)
                    ->setStore($store)
                    ->setFirstname($dataRow['fname'])
                    ->setLastname($dataRow['lname'])
                    ->setEmail($dataRow['emailaddress']);
                $customer->save();
                $this->helper->log($dataRow['emailaddress'] . " account created");
            } else {
                $this->helper->log($dataRow['emailaddress'] . " account already exists");
            }
        } catch (Exception $e) {
            $this->helper->log('We can\'t save the customer .');
        }
    }


}
