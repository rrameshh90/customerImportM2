<?php
/**
 * @author Rameshkumar
 * @package WTC_CustomerImport
 */
declare(strict_types=1);

namespace WTC\CustomerImport\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use WTC\CustomerImport\Model\ImportProfile\Csv as ImportCSV;
use WTC\CustomerImport\Helper\Data as HelperData;


class CsvProfileImport extends Command
{

    const NAME_ARGUMENT = "filename";
    const NAME_OPTION = "filename";


    /**
     * @var ImportCSV
     */
    protected ImportCSV $importCSV;

    /**
     * @var Helper
     */
    protected HelperData $helper;



    /**
     * @param ImportCSV $importCSV
     * @param HelperData $data
     */
    public function __construct(
        \WTC\CustomerImport\Model\ImportProfile\Csv $importCSV,
        HelperData $helper
    ) {
        $this->helper = $helper;
        $this->importCSV = $importCSV;
        parent::__construct();
    }


    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|void
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        $fileName = $input->getArgument(self::NAME_ARGUMENT);
        $option = $input->getOption(self::NAME_OPTION);

        if (!empty($fileName)) {
            if (!$this->helper->isValidCSVFileType($fileName)) {
                $output->writeln("Invalid File Type " . $fileName);
                return;
            }

            if (!$this->helper->isFileExists($fileName)) {
                $output->writeln("File does not exist " . $fileName);
                return;
            }
            $this->importCSV->importCustomersByCSV($fileName);
        }
    }


    /**
     * set command for magento
     */
    protected function configure()
    {
        $this->setName("customer:import:sample-csv");
        $this->setDescription("Import Customer ProfileCSV");
        $this->setDefinition([
            new InputArgument(self::NAME_ARGUMENT, InputArgument::REQUIRED, "filename"),
            new InputOption(self::NAME_OPTION, "-f", InputOption::VALUE_NONE, "CSV File")
        ]);
        parent::configure();
    }


}
