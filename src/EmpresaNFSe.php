<?php namespace PhpNFe\NFSe;

use Illuminate\Support\Arr;
use PhpNFe\Tools\Certificado\Certificado;

class EmpresaNFSe
{
    /**
     * Código do municipio da empresa.
     * 
     * @var string
     */
    protected $codMunicipio = '';

    /**
     * Configs.
     * 
     * @var array
     */
    protected $config = [];

    /**
     * Classe de controle do certificado.
     *
     * @var Certificado
     */
    protected $certificado;

    /**
     * @param Certificado $cert
     * @param array $config
     */
    public function __construct($codMunicipio, Certificado $cert, $config = [])
    {
        $this->codMunicipio = $codMunicipio;
        $this->certificado = $cert;
        $this->config = $config;
    }

    /**
     * Retorn o código do municipio.
     * 
     * @return string
     */
    public function getCodMunicipio()
    {
        return $this->codMunicipio;
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function config($key, $default = null)
    {
        return Arr::get($this->config, $key, $default);
    }

    /**
     * Retorna o manipulador do certificado.
     *
     * @return Certificado
     */
    public function getCert()
    {
        return $this->certificado;
    }
}