<?php namespace Tests;

use PhpNFe\NFSe\NFSe;

class BlumenauTest extends TestBase
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

        // Carregar NFSE
        $nfse = new NFSe($empresa);
    }
}