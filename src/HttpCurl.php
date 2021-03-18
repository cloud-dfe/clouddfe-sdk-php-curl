<?php

declare(strict_types=1);

namespace CloudDfe\SdkC;

class HttpCurl
{
    /**
     * @var bool
     */
    protected $debug = false;
    /**
     * @var string
     */
    protected $base_uri = '';
    /**
     * @var array
     */
    protected $headers = [];
    /**
     * @var array
     */
    protected $options = [];
    /**
     * @var int
     */
    protected $timeout = 10;
    /**
     * @var int
     */
    protected $http_version = 0;
    /**
     * @var int
     */
    protected $port = 443;
    /**
     * @var array
     */
    protected $error = ['code' => null, 'message' => null];

    public function __construct($config)
    {
        $this->debug = (bool) $config['debug'];
        $this->base_uri = (string) $config['base_uri'];
        $this->headers = (array) $config['headers'];
        $this->options = (array) $config['options'];
        $this->timeout = (int) $config['options']['timeout'] ?? 10;
        $this->http_version = (int) $config['options']['http_version'] ?? CURL_HTTP_VERSION_NONE;
        $this->port = (int) $config['options']['port'] ?? 443;
    }

    /**
     *
     * @param string $method
     * @param string $route
     * @param array $payload
     * @return string
     */
    public function request(string $method, string $route, array $payload = []): string
    {
        return $this->send($method, $route, $payload);
    }

    /**
     * @param string $method
     * @param string $route
     * @param array $payload
     * @return string
     */
    protected function send(string $method, string $route, array $payload = []): string
    {
        try {
            $oCurl = curl_init("{$this->base_uri}/{$route}");
        } catch (\Throwable $e) {
            throw new \Exception('Libcurl não encontrada, instale o php-curl antes de tentar usar.', 500);
        }
        curl_setopt($oCurl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($oCurl, CURLOPT_CONNECTTIMEOUT, $this->timeout);
        curl_setopt($oCurl, CURLOPT_TIMEOUT, $this->timeout + 20);
        curl_setopt($oCurl, CURLOPT_PORT, $this->port);
        curl_setopt($oCurl, CURLOPT_HTTP_VERSION, $this->http_version);
        curl_setopt($oCurl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($oCurl, CURLOPT_POSTFIELDS, $payload['body']);
        curl_setopt($oCurl, CURLOPT_HEADER, true);
        curl_setopt($oCurl, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($oCurl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, 2);
        $resp = curl_exec($oCurl);
        $this->error['message'] = curl_error($oCurl);
        $this->error['code'] = curl_errno($oCurl);
        $info = is_array(curl_getinfo($oCurl)) ? curl_getinfo($oCurl) : null;
        $httpcode = curl_getinfo($oCurl, CURLINFO_HTTP_CODE);
        curl_close($oCurl);
        if (!empty($this->error['message'])) {
            throw new \Exception("Falha de comunicação! [{$this->error['code']}] {$this->error['message']}", 500);
        }
        if ($httpcode != 200) {
            if (intval($httpcode) == 0) {
                $httpcode = 52;
            }
            throw new \Exception("Falha de comunicação! [{$httpcode}] {$resp}", 500);
        }
        return $resp;
    }
}
