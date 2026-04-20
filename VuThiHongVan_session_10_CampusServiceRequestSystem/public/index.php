<?php

require __DIR__ . '/../app/Repositories/RequestRepository.php';
require __DIR__ . '/../app/Services/RequestService.php';
require __DIR__ . '/../app/Controllers/RequestController.php';
require __DIR__ . '/../core/Router.php';

Router::resolve();