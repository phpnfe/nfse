<?php namespace PhpNFe\NFSe;

use PhpNFe\NFSe\Builder\Rps;
use PhpNFe\NFSe\Builder\RCancela;
use Illuminate\Filesystem\Filesystem;
use PhpNFe\NFSe\Contracts\NfseProviderInterface;
use PhpNFe\NFSe\Contracts\NfseRetornoInterface;

class NFSe
{
    /**
     * Lista de municipios implementados.
     *
     * @var array
     */
    protected $municipios = [];

    /**
     * Classe de controle do certificado.
     *
     * @var EmpresaNFSe
     */
    protected $empresa;

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * @param EmpresaNFSe $empresa
     */
    public function __construct(EmpresaNFSe $empresa)
    {
        $this->empresa = $empresa;
        $this->files = new Filesystem();
    }

    /**
     * Autorizar um RPS em NFSe.
     *
     * @param Rps $rps
     * @param $amb
     * @return NfseRetornoInterface
     */
    public function autorizar(Rps $rps, $amb)
    {
        return $this->getMunicipio($rps->codMun)->autorizar($rps, $amb);
    }

    /**
     * Cancelar uma NFSe emitida.
     *
     * @param RCancela $can
     * @param $amb
     * @return NfseRetornoInterface
     */
    public function cancela(RCancela $can, $amb)
    {
        return $this->getMunicipio($can->codMun)->cancela($can, $amb);
    }

    /**
     * Carregar provider do municipio.
     *
     * @param $codMun
     * @return NfseProviderInterface
     * @throws \Exception
     */
    protected function getMunicipio($codMun)
    {
        // Verificar se municipio foi carregado
        if (array_key_exists($codMun, $this->municipios)) {
            return $this->municipios[$codMun];
        }

        // Verificar se municipio foi implementado
        $arquivo_municipio = __DIR__ . '/Municipios/M' . $codMun . '/provider.php';
        if (! $this->files->exists($arquivo_municipio)) {
            throw new \Exception("Municipio [$codMun] nao foi implementado [NFSe]");
        }

        // Para o required
        $nfse    = $this;
        $empresa = $this->empresa;

        // Carregar implementacao do municipio
        return $this->municipios[$codMun] = require $arquivo_municipio;
    }
}