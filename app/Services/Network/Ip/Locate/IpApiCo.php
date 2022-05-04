<?php declare(strict_types=1);

namespace App\Services\Network\Ip\Locate;

use Exception;
use stdClass;

class IpApiCo extends LocateAbstract
{
    /**
     * @const string
     */
    protected const ENDPOINT = 'https://ipapi.co/%s/json/';

    /**
     * @param string $ip
     *
     * @return ?\stdClass
     */
    public function locate(string $ip): ?stdClass
    {
        return $this->response($this->request($ip), $ip);
    }

    /**
     * @param string $ip
     *
     * @return ?\stdClass
     */
    protected function request(string $ip): ?stdClass
    {
        return $this->curl(sprintf(static::ENDPOINT, $ip))
            ->setMethod('GET')
            ->send()
            ->getBody('object');
    }

    /**
     * @param ?\stdClass $response
     * @param string $ip
     *
     * @return \stdClass
     */
    protected function response(?stdClass $response, string $ip): stdClass
    {
        $this->responseCheck($response, $ip);

        return (object)[
            'ip' => $ip,
            'city_name' => ($response->city ?? null),
            'region_name' => ($response->region ?? null),
            'region_code' => ($response->region_code ?? null),
            'country_name' => ($response->country_name ?? null),
            'country_code' => $response->country_code,
            'latitude' => ($response->latitude ?? null),
            'longitude' => ($response->longitude ?? null),
            'asn' => ($response->asn ?? null),
            'org' => ($response->org ?? null),
        ];
    }

    /**
     * @param ?\stdClass $response
     * @param string $ip
     *
     * @return void
     */
    protected function responseCheck(?stdClass $response, string $ip): void
    {
        $message = sprintf('No Locate available to IP %s.', $ip);

        if ($response === null) {
            throw new Exception($message);
        }

        if (isset($response->error)) {
            throw new Exception($response->reason ?? $message);
        }

        if (empty($response->country_code)) {
            throw new Exception($message);
        }
    }
}
