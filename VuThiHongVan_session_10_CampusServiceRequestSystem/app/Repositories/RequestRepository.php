<?php

class RequestRepository
{
    private string $file = __DIR__ . '/../../storage/requests.json';

    public function all(): array
    {
        if (!file_exists($this->file)) return [];

        return json_decode(file_get_contents($this->file), true) ?? [];
    }

    public function find(int $id): ?array
    {
        foreach ($this->all() as $req) {
            if ($req['id'] === $id) return $req;
        }
        return null;
    }

    public function save(array $data): void
    {
        $requests = $this->all();
        $requests[] = $data;
        file_put_contents($this->file, json_encode($requests, JSON_PRETTY_PRINT));
    }

    public function updateStatus(int $id, string $status): void
    {
        $requests = $this->all();

        foreach ($requests as &$req) {
            if ($req['id'] === $id) {
                $req['status'] = $status;
            }
        }

        file_put_contents($this->file, json_encode($requests, JSON_PRETTY_PRINT));
    }
}