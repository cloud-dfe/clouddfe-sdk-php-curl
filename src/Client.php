<?php

declare(strict_types=1);

namespace CloudDfe\SdkC;

use HttpCurl;
use stdClass;

class Client
{
    /**
     * @var int
     */
    protected $ambiente = 2;
    /**
     * @var string
     */
    protected $token = '';
    /**
     * @var array
     * [
     *    'debug' => false,
     *    'timeout' => 10,
     *    'http_version' => '1.1',
     *    'port' => 443
     * ]
     */
    protected $options = [];
    /**
     * @var string
     */
    protected $uri = '';
    /**
     * @var array
     */
    protected $params = [];
    /**
     * @var HttpCurl
     */
    protected $client;

    const AMBIENTE_PRODUCAO = 1;
    const AMBIENTE_HOMOLOGACAO = 2;

    public function __construct($params = [])
    {
        $this->params = $params;
        if (empty($params)) {
            throw new \Exception("Devem ser passados os parametros básicos.");
        }
        if (!in_array($params['ambiente'], [self::AMBIENTE_PRODUCAO, self::AMBIENTE_HOMOLOGACAO])) {
            throw new \Exception("O ambiente de ser 1-produção ou 2-homologação.");
        }
        if (empty($params['token'])) {
            throw new \Exception("O token é obrigatorio.");
        }
        $this->ambiente = $params['ambiente'] ?? 2;
        $this->token = $params['token'] ?? '';
        $this->options = $params['options'] ?? [];
        $debug = false;
        if (!empty($params['options'])) {
            $debug = $params['options']['debug'] == true ? true : false;
        }
        //default homologacao
        $this->uri = 'https://hom.api.cloud-dfe.com.br/v1';
        if ($this->ambiente == self::AMBIENTE_PRODUCAO) {
            $this->uri = 'https://api.cloud-dfe.com.br/v1';
        }
        $this->client = new HttpCurl([
            'debug' => $debug,
            'base_uri' => $this->uri,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => $this->token
            ],
            'options' => $this->options
        ]);
    }

    public function send(string $method, string $route, array $payload = []): stdClass
    {
        if (!empty($payload)) {
            $json = json_encode($payload);
            $payload = ['body' => $json];
        }
        $response = $this->client->request($method, $route, $payload);
        return json_decode($response);
    }
}
