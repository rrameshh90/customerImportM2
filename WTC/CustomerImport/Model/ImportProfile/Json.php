<?php
/**
 * @author Rameshkumar
 * @package WTC_CustomerImport
 */
declare(strict_types=1);

namespace WTC\CustomerImport\Model\ImportProfile;

use Exception;
use WTC\CustomerImport\Helper\Data as HelperData;
use WTC\CustomerImport\Model\ImportCustomer;


class Json
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
     * @param $fileName
     */
    public function importCustomersByJSON($fileName)
    {
        try {
            $this->helper->log("Fetch JSON from ".$fileName);
            $jsonData=$this->helper->getJSONFileData($fileName);
            $this->importCustomers($jsonData);
        } catch (Exception $e) {
            $this->helper->log("ERROR: ".$e->getMessage());
        }
    }

    /**
     * @param $jsonData
     */
    public function importCustomers($jsonData){

        foreach ( $jsonData as $json)
        {
            try {
                $this->importCustomer->createCustomer($json);

            } catch (Exception $e) {
                $this->helper->log($e->getMessage());
            }
        }
    }
}
