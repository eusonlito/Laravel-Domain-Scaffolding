<?php declare(strict_types=1);

namespace App\Services\Csv;

class Write
{
    /**
     * @var array
     */
    protected array $data;

    /**
     * @var ?string
     */
    protected ?string $file = null;

    /**
     * @param array $data
     *
     * @return self
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param string $file
     *
     * @return self
     */
    public function file(string $file): self
    {
        $this->file = $file;

        return $this;
    }

    /**
     * @return self
     */
    public function fileTmp(): self
    {
        $this->file = tempnam(sys_get_temp_dir(), 'csv-export');

        return $this;
    }

    /**
     * @return string
     */
    public function get(): string
    {
        $fp = fopen($this->file ?: 'php://memory', 'w');

        // Added UTF-8 BOM fix in Excel
        fwrite($fp, chr(0xEF).chr(0xBB).chr(0xBF));

        fputcsv($fp, array_keys(reset($this->data)));

        foreach ($this->data as $line) {
            fputcsv($fp, $line);
        }

        if ($this->file) {
            $response = $this->file;
        } else {
            rewind($fp);

            $response = stream_get_contents($fp);
        }

        fclose($fp);

        return $response;
    }
}
