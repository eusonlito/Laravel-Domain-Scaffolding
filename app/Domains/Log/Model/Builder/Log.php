<?php declare(strict_types=1);

namespace App\Domains\Log\Model\Builder;

use App\Domains\SharedApp\Model\Builder\BuilderAbstract;

class Log extends BuilderAbstract
{
    /**
     * @param string $action
     *
     * @return self
     */
    public function byAction(string $action): self
    {
        return $this->where('action', $action);
    }

    /**
     * @param array $actions
     *
     * @return self
     */
    public function byActions(array $actions): self
    {
        return $this->whereIn('action', $actions);
    }

    /**
     * @param string $created_at
     *
     * @return self
     */
    public function byCreatedAtBefore(string $created_at): self
    {
        return $this->where('created_at', '<=', $created_at);
    }

    /**
     * @param int $id
     *
     * @return self
     */
    public function byIdPrevious(int $id): self
    {
        return $this->where('id', '<=', $id);
    }

    /**
     * @param string $related_table
     * @param int $related_id
     *
     * @return self
     */
    public function byRelated(string $related_table, int $related_id): self
    {
        return $this->byRelatedTable($related_table)->byRelatedId($related_id);
    }

    /**
     * @param string $related_table
     * @param array $related_ids
     *
     * @return self
     */
    public function byRelatedTableAndIds(string $related_table, array $related_ids): self
    {
        return $this->byRelatedTable($related_table)->byRelatedIds($related_ids);
    }

    /**
     * @param int $related_id
     *
     * @return self
     */
    public function byRelatedId(int $related_id): self
    {
        return $this->where('related_id', $related_id);
    }

    /**
     * @param array $related_ids
     *
     * @return self
     */
    public function byRelatedIds(array $related_ids): self
    {
        return $this->whereIntegerInRaw('related_id', $related_ids);
    }

    /**
     * @param string $related_table
     *
     * @return self
     */
    public function byRelatedTable(string $related_table): self
    {
        return $this->where('related_table', $related_table);
    }

    /**
     * @param string $search
     *
     * @return self
     */
    public function bySearch(string $search): self
    {
        return $this->searchLike(['action', 'related_table', 'payload'], $search);
    }

    /**
     * @return self
     */
    public function groupByAction(): self
    {
        return $this->groupBy('action')->orderBy('action');
    }

    /**
     * @return self
     */
    public function groupByRelatedTable(): self
    {
        return $this->groupBy('related_table')->orderBy('related_table');
    }

    /**
     * @return self
     */
    public function list(): self
    {
        return $this->orderBy('id', 'DESC');
    }

    /**
     * @param ?string $action
     *
     * @return self
     */
    public function whenAction(?string $action): self
    {
        return $this->when($action, static fn ($q) => $q->byAction($action));
    }

    /**
     * @param ?string $created_at
     *
     * @return self
     */
    public function whenCreatedAtBefore(?string $created_at): self
    {
        return $this->when($created_at, static fn ($q) => $q->byCreatedAtBefore($created_at));
    }

    /**
     * @param ?string $related_table
     *
     * @return self
     */
    public function whenRelatedTable(?string $related_table): self
    {
        return $this->when($related_table, static fn ($q) => $q->byRelatedTable($related_table));
    }

    /**
     * @param ?string $search
     *
     * @return self
     */
    public function whenSearch(?string $search): self
    {
        return $this->when($search, static fn ($q) => $q->bySearch($search));
    }

    /**
     * @return self
     */
    public function withRelated(): self
    {
        return $this->with('related');
    }

    /**
     * @return self
     */
    public function withUser(): self
    {
        return $this->with('user');
    }
}
