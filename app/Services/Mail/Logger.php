<?php declare(strict_types=1);

namespace App\Services\Mail;

use DateTime;
use DateTimeZone;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Facades\Event;
use Symfony\Component\Mime\Email;

class Logger
{
    /**
     * @return void
     */
    public static function listen(): void
    {
        if (config('logging.channels.mail.enabled') !== true) {
            return;
        }

        Event::listen(MessageSending::class, static fn ($event) => static::store($event));
    }

    /**
     * @param \Illuminate\Mail\Events\MessageSending $event
     *
     * @return void
     */
    protected static function store(MessageSending $event): void
    {
        $file = static::file();
        $dir = dirname($file);

        clearstatcache(true, $dir);

        if (is_dir($dir) === false) {
            mkdir($dir, 0755, true);
        }

        file_put_contents($file, static::headers($event->message)."\n\n".static::body($event->message));
    }

    /**
     * @param \Symfony\Component\Mime\Email $message
     *
     * @return string
     */
    protected static function headers(Email $message): string
    {
        return $message->getHeaders()->toString();
    }

    /**
     * @param \Symfony\Component\Mime\Email $message
     *
     * @return string
     */
    protected static function body(Email $message): string
    {
        $body = htmlspecialchars_decode($message->getBody()->bodyToString());
        $body = preg_replace('/=\r\n/', '', $body);

        return str_replace('=3D', '=', $body);
    }

    /**
     * @return string
     */
    protected static function file(): string
    {
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone('UTC'));

        return storage_path('logs/mail/'.$date->format('Y-m-d/H:i:s.u').'.log');
    }
}
