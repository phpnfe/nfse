<?php namespace Tests;

use PhpNFe\Tools\Certificado\Certificado;
use Symfony\Component\Console\Helper\Table;

class ValidarCertificadoTest extends TestBase
{
    /**
     * Nome do test
     * @var string
     */
    protected static $defaultName = 'validar:certificado';

    /**
     * Descricao do test
     * @var string
     */
    protected $description = 'Validar certificado';

    /**
     * Execuar teste.
     */
    protected function handle()
    {
        $cert_arquivo = __DIR__ . '/certs/' . $this->ask('Arquivo do certificado');
        $cert_senha = $this->ask('Senha do certificado');

        $cert = new Certificado();
        $cert->carregarPfx($cert_arquivo, $cert_senha);

        $values = [];

        // CNPJ
        $values[] = ['CNPJ do certficado', $cert->getCNPJ()];
        
        // Vencimento
        $values[] = ['Data de vencimento', $cert->getValidade()->format('d/m/Y H:i:s')];

        // Validade
        $values[] = ['Esta valido?', $cert->ehValido() ? 'SIM' : 'NAO'];

        $table = new Table($this->output);

        $table->setHeaders(['Key', 'Value']);
        $table->setRows($values);

        $table->render();
    }
}