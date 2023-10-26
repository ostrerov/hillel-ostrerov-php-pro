<?php

namespace App\Services\Proxy;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Redis;

class WebShareService
{
    public function __construct(
        protected GuzzleClient $guzzleClient
    ) {
    }

    /**
     * @throws GuzzleException
     */
    public function getProxyList(): void
    {
        $response = $this->guzzleClient->get(
            'https://proxy.webshare.io/api/v2/proxy/list',
            [
                'query' => [
                    'mode'      => 'direct',
                ],
                'headers' => [
                    'Authorization' => 'Token ' . config('proxy.key'),
                ]
            ]
        );

        $content = $response->getBody()->getContents();
        $proxies = [];

        foreach (json_decode($content)->results as $result) {
            $proxy = [
                'username'      => $result->username,
                'password'      => $result->password,
                'ip'            => $result->proxy_address,
                'port'          => $result->port,
            ];
            Redis::lpush('proxies', json_encode($proxy));
            $proxies[] = $proxy;
        }

        print_r($proxies);
    }

    public function refreshProxyList(): void
    {
        $request = $this->guzzleClient->post(
            'https://proxy.webshare.io/api/v2/proxy/list/refresh/',
            [
                'headers' => [
                    'Authorization' => 'Token ' . config('proxy.key')
                ],
            ]
        );

        $response = $request->getBody()->getContents();

        foreach (json_decode($response)->results as $result) {
            $proxy = [
                'username'      => $result->username,
                'password'      => $result->password,
                'ip'            => $result->proxy_address,
                'port'          => $result->port,
            ];

            Redis::rpush('proxies', json_encode($proxy));
        }
    }
}
