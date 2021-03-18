<?php

declare(strict_types=1);

namespace CloudDfe\SdkC;

use stdClass;

class Emitente extends Base
{
    public function token(): stdClass
    {
        return $this->client->send('GET', '/emitente/token', []);
    }

    public function atualiza(array $payload): stdClass
    {
        return $this->client->send('PUT', "/emitente", $payload);
    }

    public function mostra(): stdClass
    {
        return $this->client->send('GET', "/emitente", []);
    }
}
