<?php

declare(strict_types=1);

namespace CloudDfe\SdkC;

use stdClass;

class Dfe extends Base
{
    /**
     * @param array $payload
     * @return stdClass
     */
    public function buscaCte($payload)
    {
        return $this->client->send('POST', "/dfe/cte", $payload);
    }

    /**
     * @param array $payload
     * @return stdClass
     */
    public function buscaNfe($payload)
    {
        return $this->client->send('POST', "/dfe/nfe", $payload);
    }

    /**
     * @param array $payload
     * @return stdClass
     */
    public function backup($payload)
    {
        return $this->client->send('POST', "/dfe/backup", $payload);
    }
}
