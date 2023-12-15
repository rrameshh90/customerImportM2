<?php
/**
 * @author Rameshkumar
 * @package WTC_CustomerImport
 */
declare(strict_types=1);

namespace WTC\CustomerImport\Model\ImportProfile;

use Exception;
use Symfony\Component\Console\Helper\Helper;
use WTC\CustomerImport\Helper\Data as HelperData;
use WTC\CustomerImport\Model\ImportCustomer;


class Csv
{
    /**
     * @var Helper
     */
    protected HelperData $helper;


    /**
     * @var ImportCustomer
     */
    protected ImportCustomer $importCustomer;


    /**
     * @param HelperData $data
     * @param ImportCustomer $importCustomer
     */
    public function __construct(
        HelperData $helper,
        ImportCustomer $importCustomer
    ) {
        $this->helper = $helper;
        $this->importCustomer = $importCustomer;
    }


    /**
     * Import CSV and into Customers
     *
     * @param $fileName
     *
     * @throws Exception
     */
    public function importCustomersByCSV($fileName)
    {
        $csvContent = $this->helper->getCsvFileData($fileName);
        $csvAssociatedArray = $this->createAssociativeArray($csvContent);
        $this->helper->log("Records Found: " . count($csvAssociatedArray));
        $this->importCustomers($csvAssociatedArray);
    }

    /**
     * Loop Through  array and insert in the customer object
     *
     * @param $csvData
     */
    public function importCustomers($csvData)
    {
        foreach ($csvData as $csvRow) {
            try {
                $this->importCustomer->createCustomer($csvRow);
            } catch (Exception $e) {
                $this->helper->log($e->getMessage());
            }
        }
    }

    /**
     * @param $csvRows
     *
     * @return array
     */
    public function createAssociativeArray($csvRows): array
    {
        try {
            $csvAssociatedArray = [];
            $csvHeader = array_shift($csvRows);
            foreach ($csvRows as $csvRow) {
                $csvAssociatedArray[] = array_combine($csvHeader, $csvRow);
            }
            return $csvAssociatedArray;
        } catch (Exception $e) {
            $this->helper->log("ERROR: " . $e->getMessage());
        }
    }

}
