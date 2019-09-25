<?php namespace Tests;

use PhpNFe\NFSe\NFSe;
use PhpNFe\NFSe\Contracts\NfseProviderInterface;
use Symfony\Component\Console\Input\InputArgument;

class SC_BC_Cancelar_Test extends TestBase
{
    /**
     * Nome do test
     * @var string
     */
    protected static $defaultName = 'bc:cancelar';

    /**
     * Descricao do test
     * @var string
     */
    protected $description = 'Cancelar uma autorizacao de uma NFSe/RPS para Balneario Camboriu - SC';

    /**
     * Execuar teste.
     */
    protected function handle()
    {
        // Carregar a empresa de bnu
        $empresa = require __DIR__ . '/config_sc_bc.php';

        // Gerar rps
        $rps = require __DIR__ . '/rps/rps_sc_bc_cristoluz.php';

        // Carregar NFSE
        $nfse = new NFSe($empresa);

        $nfse_num = $this->input->getArgument('nfsenum');

        // Montar request do Cancelar
        $can           = new \PhpNFe\NFSe\Builder\RCancela();
        $can->cnpj     = $rps->prestador->identificacao->cnpj;
        $can->codMun   = $rps->codMun;
        $can->inscrMun = $rps->prestador->identificacao->inscricaoMun;
        $can->numNfse  = $nfse_num;
        $can->motivo   = 'Teste de cancelamento de NFSE';

        $ret = $nfse->cancela($can, NfseProviderInterface::ambNfseHomologacao);

        if ($ret->isError()) {
            throw new \Exception($ret->getErros());
        }

        $xml = $ret->getXmlProt();
        file_put_contents(__DIR__ . '/outs/ret_sc_bc_cancelar.xml', $xml);

        $this->info('NFSe - CANCELADA');
    }

    /**
     * Configure command
     */
    protected function configure()
    {
        parent::configure();

        $this->addArgument('nfsenum', InputArgument::REQUIRED, 'Numero da NFSe autorizada');
    }
}
