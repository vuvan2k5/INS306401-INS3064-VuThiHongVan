<?php

class Request
{
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public string $status = "Pending"
    ) {}
}