<?php

namespace App\Services\GetMyIpService;

use App\Services\Proxy\WebShareService;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Facades\Redis;

class GetMyIpService
{
    public function __construct(
        protected GuzzleClient $guzzleClient,
        protected WebShareService $webShareService,
    ) {
    }

    public function handle(): string
    {
        $countProxies = count(Redis::lrange('proxies', 0, 10));

        if ($countProxies < 5) {
            Redis::del('proxies');
            $this->webShareService->refreshProxyList();
        }

        $proxy = json_decode(Redis::lpop('proxies'), true);
        $userData = $proxy['username'] . ':' . $proxy['password'];

        $startTime = microtime(true);

        $response = $this->guzzleClient->get(
            'https://api.myip.com/',
            [
                'proxy' => 'http://' . $userData . '@' . $proxy['ip'] . ':' . $proxy['port'],
            ]
        );
        $time = microtime(true) - $startTime;
        if ($time < 1) {
            Redis::rpush('proxies', json_encode($proxy));
        }

        return $response->getBody()->getContents();
    }
}
