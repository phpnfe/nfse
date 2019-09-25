<?php namespace Tests;

use PhpNFe\NFSe\NFSe;
use PhpNFe\NFSe\Contracts\NfseProviderInterface;

class SC_BC_Autorizar_Test extends TestBase
{
    /**
     * Nome do test
     * @var string
     */
    protected static $defaultName = 'bc:autorizar';

    /**
     * Descricao do test
     * @var string
     */
    protected $description = 'Autorizar uma RPS para Balneario Camboriu - SC';

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

        $ret = $nfse->autorizar($rps, NfseProviderInterface::ambNfseHomologacao);

        if ($ret->isError()) {
            throw new \Exception($ret->getErros());
        }  
        
        $xml = $ret->getXmlProt();
        file_put_contents(__DIR__ . '/outs/ret_sc_bc_autorizar.xml', $xml);                

        $this->info('NFSe - AUTORIZADA');
    }
}