<?php

class RequestService
{
    public function __construct(
        private RequestRepository $repo
    ) {}

    public function getAll(): array
    {
        return $this->repo->all();
    }

    public function getById(int $id): ?array
    {
        return $this->repo->find($id);
    }

    public function create(string $title, string $description): void
    {
        $data = [
            'id' => rand(1, 99999),
            'title' => $title,
            'description' => $description,
            'status' => 'Pending'
        ];

        $this->repo->save($data);
    }

    public function changeStatus(int $id, string $status): void
    {
        $this->repo->updateStatus($id, $status);
    }
}