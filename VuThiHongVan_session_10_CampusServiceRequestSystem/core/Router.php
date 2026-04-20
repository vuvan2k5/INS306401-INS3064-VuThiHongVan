<?php

class Router
{
    public static function resolve(): void
    {
        $repo = new RequestRepository();
        $service = new RequestService($repo);
        $controller = new RequestController($service);

        $action = $_GET['action'] ?? 'index';

        match ($action) {
            'show' => $controller->show(),
            'store' => $controller->store(),
            'updateStatus' => $controller->updateStatus(),
            default => $controller->index(),
        };
    }
}