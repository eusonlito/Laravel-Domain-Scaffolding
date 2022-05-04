<?php declare(strict_types=1);

namespace App\Services\Network\Ip\Locate;

use Exception;
use stdClass;

class IpApiCom extends LocateAbstract
{
    /**
     * @const string
     */
    protected const ENDPOINT = 'http://ip-api.com/json/%s';

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
            'region_name' => ($response->regionName ?? null),
            'region_code' => ($response->region ?? null),
            'country_name' => ($response->country ?? null),
            'country_code' => $response->countryCode,
            'latitude' => ($response->lat ?? null),
            'longitude' => ($response->lon ?? null),
            'asn' => ($response->as ?? null),
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

        if ($response->status === 'fail') {
            throw new Exception($response->message ?? $message);
        }

        if (empty($response->countryCode)) {
            throw new Exception($message);
        }
    }
}
