<?php declare(strict_types=1);

namespace App\Domains\Log\Model\Traits;

use App\Domains\Log\Model\LogRelated as LogRelatedModel;

trait Payload
{
    /**
     * @var array
     */
    protected ?array $payloadRow;

    /**
     * @var array
     */
    protected ?array $payloadRowOther;

    /**
     * @return ?array
     */
    public function payloadRow(): ?array
    {
        return $this->payloadRow ??= $this->related->first(
            fn ($value) => $this->payloadRowIsSame($value)
        )->payload['row'] ?? null;
    }

    /**
     * @param \App\Domains\Log\Model\LogRelated $related
     *
     * @return bool
     */
    protected function payloadRowIsSame(LogRelatedModel $related): bool
    {
        return ($related->related_table === $this->related_table)
            && ($related->related_id === $this->related_id);
    }

    /**
     * @return ?array
     */
    public function payloadRowOther(): ?array
    {
        return $this->payloadRowOther ??= $this->related->first(
            fn ($value) => $this->payloadRowIsDifferent($value)
        )->payload['row'] ?? null;
    }

    /**
     * @param \App\Domains\Log\Model\LogRelated $related
     *
     * @return bool
     */
    protected function payloadRowIsDifferent(LogRelatedModel $related): bool
    {
        return ($related->related_table !== $this->related_table)
            || ($related->related_id !== $this->related_id);
    }

    /**
     * @param string $key
     *
     * @return string
     */
    public function payloadPrint(string $key): string
    {
        return helper()->jsonEncode($this->payload[$key] ?? '');
    }
}
