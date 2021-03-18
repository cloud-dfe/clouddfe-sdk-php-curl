# Operações com CTe

*NOTA: estas operações funcionam em ambos os ambientes (homologação e produção)*

*NOTA: Esta operação somente pode ser executada com o token do emitente.*

**LEMBRE-SE: as consultas usando o SDK sempre retornam um objeto stdClass;**


## Consulta Status da Sefaz autorizadora

Consulta o status da SEFAZ autorizadora

```php
use CloudDfe\SdkC\Client;
use CloudDfe\SdkC\Cte;

try {

    //token de emitente
    $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9 ....';
    $ambiente = Client::AMBIENTE_HOMOLOGACAO;
    $options = [
        'debug' => false
    ];

    $client = new Client([
        'ambiente' => $ambiente,
        'token' => $token,
        'options' => $options
    ]);

    $cte = new Cte($client);

    $resp = $cte->status();

    echo "<pre>";
    print_r($resp); //imprime o objeto $resp em tela
    echo "</pre>";

} catch (\Exception $e) {
    echo $e->getMessage();
}
```

## Cria CTe

Este método é usado paa GERAR uma nova CTe

*NOTA: como o processo é ASSINCRONO, então é necessária que uma segunda chamada (**Consulta**) seja feita alguns segundos após o envio desta chamada para se obter o resultado do precessamento da CTe pela SEFAZ autorizadora, isso se esta chamada retornar sucesso, é claro.*

É muito importante que estude a [nossa documentação](https://doc.cloud-dfe.com.br/v1/cte/manual/index.html) para poder enviar essa chamada.


```php
use CloudDfe\SdkC\Client;
use CloudDfe\SdkC\Cte;

try {

    //token de emitente
    $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9 ....';
    $ambiente = Client::AMBIENTE_HOMOLOGACAO;
    $options = [
        'debug' => false
    ];

    $client = new Client([
        'ambiente' => $ambiente,
        'token' => $token,
        'options' => $options
    ]);

    $cte = new Cte($client);

    $paylod = [
        "cfop" => "5353",
        "natureza_operacao" => "PRESTACAO DE SERVIÇO",
        "numero" => "64",
        "serie" => "1",
        "data_emissao" => "2020-11-24T03:00:00-03:00",
        "tipo_operacao" => "0",
        "codigo_municipio_envio" => "2408003",
        "nome_municipio_envio" => "MOSSORO",
        "uf_envio" => "RN",
        "tipo_servico" => "0",
        "codigo_municipio_inicio" => "2408003",
        "nome_municipio_inicio" => "Mossoró",
        "uf_inicio" => "RN",
        "codigo_municipio_fim" => "2408003",
        "nome_municipio_fim" => "Mossoró",
        "uf_fim" => "RN",
        "retirar_mercadoria" => "1",
        "detalhes_retirar" => null,
        "tipo_programacao_entrega" => "0",
        "sem_hora_tipo_hora_programada" => "0",
        "remetente" => [
            "cnpj" => "15493526000128",
            "inscricao_estadual" => "239084510",
            "nome" => "EMPRESA MODELO",
            "razao_social" => "MODELO LTDA",
            "telefone" => "8433163070",
            "endereco" => [
                "logradouro" => "AVENIDA TESTE",
                "numero" => "444",
                "bairro" => "CENTRO",
                "codigo_municipio" => "2408003",
                "nome_municipio" => "MOSSORÓ",
                "uf" => "RN"
            ]
        ],
        "valores" => [
            "valor_total" => "0.00",
            "valor_receber" => "0.00",
            "valor_total_carga" => "224.50",
            "produto_predominante" => "SAL",
            "quantidades" => [
                [
                    "codigo_unidade_medida" => "01",
                    "tipo_medida" => "Peso Bruto",
                    "quantidade" => "500.00"
                ]
            ]
        ],
        "imposto" => [
            "icms" => [
                "situacao_tributaria" => "20",
                "valor_base_calculo" => "0.00",
                "aliquota" => "12.00",
                "valor" => "0.00",
                "reducao_base_calculo" => "50.00"
            ]
        ],
        "nfes" => [
            [
                "chave" => "24201001243220000109550010000010611650858974"
            ]
        ],
        "modal_rodoviario" => [
            "rntrc" => "02033517"
        ],
        "destinatario" => [
            "cnpj" => "15495526000128",
            "inscricao_estadual" => "212055510",
            "nome" => "EMPRESA MODELO",
            "telefone" => "8499995555",
            "endereco" => [
                "logradouro" => "AVENIDA TESTE",
                "numero" => "444",
                "bairro" => "CENTRO",
                "codigo_municipio" => "2408003",
                "nome_municipio" => "Mossoró",
                "cep" => "59603330",
                "uf" => "RN",
                "codigo_pais" => "1058",
                "nome_pais" => "BRASIL",
                "email" => "teste@teste.com.br"
            ]
        ],
        "componentes_valor" => [
            [
                "nome" => "teste2",
                "valor" => "1999.00"
            ]
        ],
        "tomador" => [
            "tipo" => "3",
            "indicador_inscricao_estadual" => "1"
        ],
        "observacao" => ""
    ];
    $resp = $cte->cria($paylod); //os payloads são sempre ARRAYS

    echo "<pre>";
    print_r($resp); //imprime o objeto $resp em tela
    echo "</pre>";

} catch (\Exception $e) {
    echo $e->getMessage();
}
```

## Busca CTe

Busca pelos documentos armazenados em nossa base de dados

```php
use CloudDfe\SdkC\Client;
use CloudDfe\SdkC\Cte;

try {

    //token de emitente
    $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9 ....';
    $ambiente = Client::AMBIENTE_HOMOLOGACAO;
    $options = [
        'debug' => false
    ];

    $client = new Client([
        'ambiente' => $ambiente,
        'token' => $token,
        'options' => $options
    ]);

    $cte = new Cte($client);

    $resp = $cte->busca([
        "numero_inicial" => 1710,
        "numero_final" => 101002,
        "serie" => 1,
        //"data_inicial" => "2019-12-01",
        //"data_final" => "2019-12-31",
        //"cancel_inicial" => "2019-12-01", // Cancelamento
        //"cancel_final" => "2019-12-31"
    ]);  //os payloads são sempre ARRAYS

    echo "<pre>";
    print_r($resp); //imprime o objeto $resp em tela
    echo "</pre>";

} catch (\Exception $e) {
    echo $e->getMessage();
}
```

## Consulta CTe

Consulta uma CTe em nossa base de dados. Este método é normalmente usado logo após a CTe ter sido enviada para api.

```php
use CloudDfe\SdkC\Client;
use CloudDfe\SdkC\Cte;

try {

    //token de emitente
    $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbXAiOjcwLCJ1c3IiOiIyIiwidHAiOjIsImlhdCI6MTU4MDkzNzM3MH0.KvSUt2x8qcu4Rtp2XNTOINqR-3c5V8iyITDmLoUF_SE';
    $ambiente = Client::AMBIENTE_HOMOLOGACAO;
    $options = [
        'debug' => false
    ];

    $client = new Client([
        'ambiente' => $ambiente,
        'token' => $token,
        'options' => $options
    ]);

    $cte = new Cte($client);

    $resp = $cte->consulta([
        'chave' => '41210222545265000108570010001010021121093113'
    ]);

    echo "<pre>";
    print_r($resp);
    echo "</pre>";

} catch (\Exception $e) {
    echo $e->getMessage();
}
```


## Carta da Correção

A carta de correção é usada para corrigir algum equivoco simples que tenha ocorrido na emissão da CTe, e que não tem impacto nos dados fiscais da mesma.

```php
use CloudDfe\SdkC\Client;
use CloudDfe\SdkC\Cte;

try {

    //token de emitente
    $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9 ....';
    $ambiente = Client::AMBIENTE_HOMOLOGACAO;
    $options = [
        'debug' => false
    ];

    $client = new Client([
        'ambiente' => $ambiente,
        'token' => $token,
        'options' => $options
    ]);

    $cte = new Cte($client);

    $payload = [
        'chave' => '41210222545265000108570010001010031384099675',
        'correcoes' => [
            [
                'grupo_corrigido' => 'ide',
                'campo_corrigido' => 'natureza_operacao',
                'valor_corrigido' => 'PRESTACAO DE SERVIÇO'
            ]
        ]
    ];
    $resp = $cte->correcao($payload); //os payloads são sempre ARRAYS

    echo "<pre>";
    print_r($resp); //imprime o objeto $resp em tela
    echo "</pre>";

} catch (\Exception $e) {
    echo $e->getMessage();
}

```

## Cancela CTe

Este método solicita o cancelamento da CTe à Sefaz autorizadora.

*NOTA: para poder cancelar uma CTe utilizando a API é necessário que o documento exista em nossa base de dados.*

**NOTA: Atenção para os prazos limite para realizar o cancelamento de CTe, de forma geral esse limite é de 24 horas a partir da data de emissão do documento. Após esse limite as CTe não poderão mais serem canceladas e para reverter a operação será necessário fazer uma CTe de entrada das mercadorias.**

```php
use CloudDfe\SdkC\Client;
use CloudDfe\SdkC\Cte;

try {

    //token de emitente
    $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9 ...';
    $ambiente = Client::AMBIENTE_HOMOLOGACAO;
    $options = [
        'debug' => false
    ];

    $client = new Client([
        'ambiente' => $ambiente,
        'token' => $token,
        'options' => $options
    ]);

    $cte = new Cte($client);

    $payload = [
        'chave' => '41210222545265000108570010001010021121093113',
        'justificativa' => 'teste de cancelamento' //minimo de 15 caracteres
    ];
    $resp = $cte->cancela($payload); //os payloads são sempre ARRAYS

    echo "<pre>";
    print_r($resp); //imprime o objeto $resp em tela
    echo "</pre>";

} catch (\Exception $e) {
    echo $e->getMessage();
}
```

## Inutiliza Faixa de Numeros de CTe

Sempre que por algum motivo tenham sido pulados numeros de CTe, esses numeros deve ser inulizados.

*NOTA: mesmo que deseje encerrar apenas um unico numero de CTe, nessa chamada deve ser passado o numero inicial e final IGUAIS.*

```php
use CloudDfe\SdkC\Client;
use CloudDfe\SdkC\Cte;

try {

    //token de emitente
    $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9 ....';
    $ambiente = Client::AMBIENTE_HOMOLOGACAO;
    $options = [
        'debug' => false
    ];

    $client = new Client([
        'ambiente' => $ambiente,
        'token' => $token,
        'options' => $options
    ]);

    $cte = new Cte($client);

    $payload = [
        'numero_inicial' => '101004',
        'numero_final' => '101004',
        'serie' => '1',
        'justificativa' => 'teste de inutilização'
    ];
    $resp = $cte->inutiliza($payload); //os payloads são sempre ARRAYS

    echo "<pre>";
    print_r($resp); //imprime o objeto $resp em tela
    echo "</pre>";

} catch (\Exception $e) {
    echo $e->getMessage();
}
```

## Gerar DACTE (pdf)

Com este método será retornado o PDF da DACTE de um documento que exista na nossa base de dados.

```php
use CloudDfe\SdkC\Client;
use CloudDfe\SdkC\Cte;

try {

    //token de emitente
    $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9 ...';
    $ambiente = Client::AMBIENTE_HOMOLOGACAO;
    $options = [
        'debug' => false
    ];

    $client = new Client([
        'ambiente' => $ambiente,
        'token' => $token,
        'options' => $options
    ]);

    $cte = new Cte($client);

    $payload = [
        'chave' => '41210222545265000108570010001010031384099675'
    ];
    $resp = $cte->pdf($payload); //os payloads são sempre ARRAYS

    echo "<pre>";
    print_r($resp); //imprime o objeto $resp em tela
    echo "</pre>";

} catch (\Exception $e) {
    echo $e->getMessage();
}
```


## Backup

Solicita o backup dos documentos relacionados com as CTe (CTe e eventos), gerados e registrados pela API


```php

use CloudDfe\SdkC\Client;
use CloudDfe\SdkC\Cte;

try {

    //token de emitente
    $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9 ....';
    $ambiente = Client::AMBIENTE_HOMOLOGACAO;
    $options = [
        'debug' => false
    ];

    $client = new Client([
        'ambiente' => $ambiente,
        'token' => $token,
        'options' => $options
    ]);

    $cte = new Cte($client);

    $payload = [
        'ano' => '2021',
        'mes' => '2'
    ];
    $resp = $cte->backup($payload); //os payloads são sempre ARRAYS

    echo "<pre>";
    print_r($resp); //imprime o objeto $resp em tela
    echo "</pre>";

} catch (\Exception $e) {
    echo $e->getMessage();
}
```
