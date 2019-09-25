<?php namespace Tests;

use PhpNFe\NFSe\NFSe;
use PhpNFe\NFSe\Contracts\NfseProviderInterface;

class SC_BNU_Autorizar_Test extends TestBase
{
    /**
     * Nome do test
     * @var string
     */
    protected static $defaultName = 'bnu:autorizar';

    /**
     * Descricao do test
     * @var string
     */
    protected $description = 'Autorizar uma RPS para Blumenau - SC';

    /**
     * Execuar teste.
     */
    protected function handle()
    {
        // Carregar a empresa de bnu
        $empresa = require __DIR__ . '/config_sc_bnu.php';

        // Validar certificado
        if (! $empresa->getCert()->ehValido()) {
            throw new \Exception("Certificado invalido");
        }

        // Gerar rps
        $rps = require __DIR__ . '/rps/rps_sc_bnu_netforce.php';

        // Carregar NFSE
        $nfse = new NFSe($empresa);

        $ret = $nfse->autorizar($rps, NfseProviderInterface::ambNfseHomologacao);

        if ($ret->isError()) {
            throw new \Exception($ret->getErros());
        }  
        
        $xml = $ret->getXmlProt();
        file_put_contents(__DIR__ . '/outs/ret_sc_bnu_autorizar.xml', $xml);                

        $this->info('NFSe - AUTORIZADA');
    }
}