<?php declare(strict_types=1);

namespace App\Domains\Storage\Action;

use Throwable;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Domains\Storage\Service\Transform\Logger;
use App\Domains\Storage\Service\Transform\Url as UrlTransformService;
use App\Services\Image\Transform as TransformService;

class Transform extends ActionAbstract
{
    /**
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function handle(): StreamedResponse
    {
        try {
            $this->process();
        } catch (Throwable $e) {
            $this->error($e);
        }

        return $this->response();
    }

    /**
     * @return void
     */
    protected function process(): void
    {
        $this->data();
        $this->check();
        $this->transform();
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataFile();
        $this->dataAbsolute();
        $this->dataTarget();
        $this->dataTransform();
    }

    /**
     * @return void
     */
    protected function dataFile(): void
    {
        $path = implode('/', array_filter(array_map('str_slug', explode('/', dirname($this->data['file'])))));
        $name = implode('.', array_filter(array_map('str_slug', explode('.', basename($this->data['file'])))));

        $this->data['file'] = UrlTransformService::path($path.'/'.$name);
    }

    /**
     * @return void
     */
    protected function dataAbsolute(): void
    {
        $this->data['absolute'] = public_path($this->data['file']);
    }

    /**
     * @return void
     */
    protected function dataTarget(): void
    {
        $this->data['target'] = '/'.ltrim($this->request->path(), '/');
    }

    /**
     * @return void
     */
    protected function dataTransform(): void
    {
        $this->data['transform'] = str_replace(['_', '-'], [',', '|'], $this->data['transform']);
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkHash();
        $this->checkFile();
        $this->checkMime();
    }

    /**
     * @return void
     */
    protected function checkHash(): void
    {
        if (UrlTransformService::hash($this->data['file'], $this->data['transform']) !== $this->data['hash']) {
            $this->exceptionNotFound();
        }
    }

    /**
     * @return void
     */
    protected function checkFile(): void
    {
        if (is_file($this->data['absolute']) === false) {
            $this->exceptionNotFound();
        }
    }

    /**
     * @return void
     */
    protected function checkMime(): void
    {
        if (str_starts_with(mime_content_type($this->data['absolute']), 'image/') === false) {
            $this->exceptionNotFound();
        }
    }

    /**
     * @return void
     */
    protected function transform(): void
    {
        $this->data['url'] = TransformService::image($this->data['file'], $this->data['transform'], $this->data['target']);
        $this->data['absolute'] = public_path(parse_url($this->data['url'], PHP_URL_PATH));

        clearstatcache(true, $this->data['absolute']);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    protected function response(): StreamedResponse
    {
        return response()->stream(fn () => $this->readfile(), $this->status(), $this->headers());
    }

    /**
     * @return void
     */
    protected function readfile(): void
    {
        if (is_file($this->data['absolute'])) {
            readfile($this->data['absolute']);
        }
    }

    /**
     * @return int
     */
    protected function status(): int
    {
        return is_file($this->data['absolute']) ? 200 : 404;
    }

    /**
     * @return array
     */
    protected function headers(): array
    {
        return [
            'Content-Type' => $this->headersContentType(),
            'X-Cache' => 'MISS',
        ];
    }

    /**
     * @return string
     */
    protected function headersContentType(): string
    {
        $extension = strtolower(pathinfo($this->request->path(), PATHINFO_EXTENSION));
        $mime = ($extension === 'jpg') ? 'jpeg' : $extension;

        return 'image/'.$mime;
    }

    /**
     * @param \Throwable $e
     *
     * @return void
     */
    protected function error(Throwable $e): void
    {
        Logger::error($this->request->url(), [
            'data' => $this->data,
            'message' => $e->getMessage(),
            'trace' => $e->getTrace(),
        ]);

        $this->exceptionNotFound();
    }
}
