<?php

namespace App\Services;

class GlassnodeService
{
    private string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.glassnode.key');
    }

    public function getTransferVolumeSums(string $symbol, string $range, string $dateFrom)
    {
        $ch = curl_init();

        $endpoint = "https://api.glassnode.com/v1/metrics/transactions/transfers_volume_sum";
        $params = [
            'a' => $symbol,
            'i' => $range,
            'u' => time(),
            's' => strtotime('-' . $dateFrom),
        ];
        $url = $endpoint . '?' . http_build_query($params);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-Api-Key: ' . $this->apiKey,
        ));

        $res = json_decode(curl_exec($ch));

        curl_close($ch);

        return $res;
    }
}
