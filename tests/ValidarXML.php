<?php namespace Tests;

use PhpNFe\Tools\Validar;
use Symfony\Component\Console\Input\InputArgument;

class ValidarXML extends TestBase
{
    /**
     * Nome do test
     * @var string
     */
    protected static $defaultName = 'validar:xml';

    /**
     * Descricao do test
     * @var string
     */
    protected $description = 'Validar XML pelo XSD';

    /**
     * Execuar teste.
     */
    protected function handle()
    {
        $xml_arquivo = $this->input->getArgument('arquivo_xml');
        $xsd_arquivo = $this->input->getArgument('arquivo_xsd');

        $xml = file_get_contents($xml_arquivo);

        Validar::validar($xml, $xsd_arquivo);
    }


    /**
     * Configure command
     */
    protected function configure()
    {
        parent::configure();

        $this->addArgument('arquivo_xml', InputArgument::REQUIRED, 'Caminho do arquivo XML');
        $this->addArgument('arquivo_xsd', InputArgument::REQUIRED, 'Caminho do arquivo XSD');
    }
}