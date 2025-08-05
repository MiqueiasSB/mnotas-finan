<?php

namespace App\Repositories\Eloquent;

use App\Models\SubscriptionItem;
use App\Repositories\Interfaces\SubscriptionItemInterface;
use Illuminate\Support\Collection;

class SubscriptionItemRepository implements SubscriptionItemInterface
{
    public function all(): Collection
    {
        return SubscriptionItem::all();
    }

    public function find(int $id): ?SubscriptionItem
    {
        return SubscriptionItem::find($id);
    }

    public function create(array $data): SubscriptionItem
    {
        return SubscriptionItem::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $subscriptionItem = $this->find($id);
        return $subscriptionItem ? $subscriptionItem->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $subscriptionItem = $this->find($id);
        return $subscriptionItem ? $subscriptionItem->delete() : false;
    }
}
