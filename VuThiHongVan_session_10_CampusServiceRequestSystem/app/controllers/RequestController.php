<?php

class RequestController
{
    public function __construct(
        private RequestService $service
    ) {}

    public function index(): void
    {
        $requests = $this->service->getAll();
        require __DIR__ . '/../Views/requests/index.php';
    }

    public function show(): void
    {
        $id = $_GET['id'] ?? null;
        $request = $this->service->getById((int)$id);

        require __DIR__ . '/../Views/requests/show.php';
    }

    public function store(): void
    {
        $this->service->create($_POST['title'], $_POST['description']);
        header("Location: /");
    }

    public function updateStatus(): void
    {
        $this->service->changeStatus($_POST['id'], $_POST['status']);
        header("Location: /?action=show&id=" . $_POST['id']);
    }
}