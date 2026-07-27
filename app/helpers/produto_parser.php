<?php

/**
 * Extrai Implemento (configuracao) e Carroceria a partir do titulo/nome do
 * produto. Usado tanto pelo sync com a Loja Integrada quanto por scripts de
 * backfill que rodam direto sobre os produtos ja existentes no banco.
 *
 * Ordem importa: termos mais especificos (ex: "vanderleia") vem antes de
 * termos genericos (ex: "carreta"), pois um produto "Carreta ... Vanderleia
 * (3ED) ..." e classificado como Vanderleia, nao como 4 Eixos.
 */
function parse_implemento_carroceria(string $titulo): array
{
    $t = mb_strtolower($titulo, 'UTF-8');

    $config = null;
    $configs = [
        'vanderleia 3ed' => 'Vanderléia',
        'vanderleia'     => 'Vanderléia',
        'vanderléia'     => 'Vanderléia',
        'britrenzao'     => '9 Eixos / Bitrenzão',
        'britrenzão'     => '9 Eixos / Bitrenzão',
        'bitrenzao'      => '9 Eixos / Bitrenzão',
        'bitrenzão'      => '9 Eixos / Bitrenzão',
        '9 eixos'        => '9 Eixos / Bitrenzão',
        'bitrem'         => 'Bitrem',
        'rodotrem'       => 'Rodotrem',
        ' ls '           => 'LS',
        'carreta'        => '4 Eixos (Simples)',
        '4 eixos'        => '4 Eixos (Simples)',
    ];
    foreach ($configs as $key => $val) {
        if (str_contains($t, $key)) { $config = $val; break; }
    }

    $carroceria = 'Tanque';
    if (str_contains($t, 'rodocaçamba') || str_contains($t, 'rodocacamba')) {
        $carroceria = 'Tanque Rodocaçamba';
    } elseif (str_contains($t, 'sider')) {
        $carroceria = 'Tanque Sider';
    } elseif (str_contains($t, 'graneleiro') || str_contains($t, 'graneleira')) {
        $carroceria = str_contains($t, 'tanque') ? 'Tanque Graneleiro' : 'Graneleiro';
    }

    return ['config' => $config, 'carroceria' => $carroceria];
}
