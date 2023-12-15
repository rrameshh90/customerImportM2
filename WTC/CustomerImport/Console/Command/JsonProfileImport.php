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
use WTC\CustomerImport\Model\ImportProfile\Json as ImportJSON;
use WTC\CustomerImport\Helper\Data as HelperData;


class JsonProfileImport extends Command
{
    const NAME_ARGUMENT = "filename";
    const NAME_OPTION = "filename";


    /**
     * @var Helper
     */
    protected HelperData $helper;

    /**
     * @var ImportJSON
     */
    protected ImportJSON $importJSON;


    public function __construct(
        \WTC\CustomerImport\Model\ImportProfile\Json $importJSON,
        HelperData $helper
    ) {
        $this->importJSON = $importJSON;
        $this->helper = $helper;

        parent::__construct();
    }

    /**
     *  configure commands
     */
    protected function configure()
    {
        $this->setName("customer:import:sample-json");
        $this->setDescription("Import Customer ProfileJSON");
        $this->setDefinition([
            new InputArgument(self::NAME_ARGUMENT, InputArgument::REQUIRED, "filename"),
            new InputOption(self::NAME_OPTION, "-f", InputOption::VALUE_NONE, "JSON File")
        ]);
        parent::configure();
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
        $output->writeln("JSON" . $fileName);

        if (!empty($fileName)) {
            if (!$this->helper->isValidJSONFileType($fileName)) {
                $output->writeln("Invalid File Type " . $fileName);
                return;
            }
            if (!$this->helper->isFileExists($fileName)) {
                $output->writeln("File does not exist " . $fileName);
                return;
            }
            $this->importJSON->importCustomersByJSON($fileName);
        }
    }
}

