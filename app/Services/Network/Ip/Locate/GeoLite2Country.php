<?php declare(strict_types=1);

namespace App\Services\Network\Ip\Locate;

use Exception;
use stdClass;
use MaxMind\Db\Reader;

class GeoLite2Country extends LocateAbstract
{
    /**
     * @const string
     */
    protected const FILE = 'vendor/wp-statistics/geolite2-country/GeoLite2-Country.mmdb';

    /**
     * @var string
     */
    protected string $db;

    /**
     * @param string $ip
     *
     * @return ?\stdClass
     */
    public function locate(string $ip): ?stdClass
    {
        if ($this->isAvailable() === false) {
            return null;
        }

        return $this->response($this->request($ip), $ip);
    }

    /**
     * @return string
     */
    protected function db(): string
    {
        return $this->db ??= base_path(static::FILE);
    }

    /**
     * @return bool
     */
    protected function isAvailable(): bool
    {
        return is_file($this->db());
    }

    /**
     * @param string $ip
     *
     * @return array
     */
    protected function request(string $ip): array
    {
        return (new Reader($this->db()))->get($ip);
    }

    /**
     * @param ?array $response
     * @param string $ip
     *
     * @return \stdClass
     */
    protected function response(?array $response, string $ip): stdClass
    {
        $this->responseCheck($response, $ip);

        return (object)[
            'ip' => $ip,
            'city_name' => null,
            'region_name' => null,
            'region_code' => null,
            'country_name' => ($response['country']['names']['en'] ?? current($response['country']['names'])),
            'country_code' => $response['country']['iso_code'],
            'latitude' => null,
            'longitude' => null,
            'asn' => null,
            'org' => null,
        ];
    }

    /**
     * @param ?array $response
     * @param string $ip
     *
     * @return void
     */
    protected function responseCheck(?array $response, string $ip): void
    {
        $message = sprintf('No Locate available to IP %s.', $ip);

        if ($response === null) {
            throw new Exception($message);
        }

        if (empty($response['country']['iso_code'])) {
            throw new Exception($message);
        }
    }
}
