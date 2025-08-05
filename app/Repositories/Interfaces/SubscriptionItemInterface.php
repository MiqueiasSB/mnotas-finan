<?php
namespace App\Repositories\Interfaces;

use App\Models\SubscriptionItem;
use Illuminate\Support\Collection;

interface SubscriptionItemInterface{
    public function all(): Collection;
    public function find(int $id): ? SubscriptionItem;
    public function create(array $data): SubscriptionItem;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}
