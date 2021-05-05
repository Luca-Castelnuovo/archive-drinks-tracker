<?php

declare(strict_types=1);

use App\Controllers\AuthWebhookController;
use App\Controllers\EntriesController;
use App\Controllers\GeneralController;
use App\Controllers\UserController;
use App\Middleware\AuthKeyMiddleware;
use CQ\Controllers\AuthCodeController;
use CQ\Controllers\AuthDeviceController;
use CQ\Middleware\AuthMiddleware;
use CQ\Middleware\FormMiddleware;
use CQ\Middleware\JsonMiddleware;

$route->get('/', [GeneralController::class, 'index']);

$middleware->create(['middleware' => [FormMiddleware::class]], static function () use ($route): void {
    $route->post('/upload', [GeneralController::class, 'upload']);
});

$middleware->create(['prefix' => '/auth'], static function () use ($route, $middleware): void {
    $route->get('/request', [AuthCodeController::class, 'request']);
    $route->get('/callback', [AuthCodeController::class, 'callback']);
    $route->get('/logout', [AuthCodeController::class, 'logout']);

    $route->get('/request/device', [AuthDeviceController::class, 'request']);
    $route->post('/callback/device', [AuthDeviceController::class, 'callback']);

    $middleware->create(['middleware' => [JsonMiddleware::class]], static function () use ($route): void {
        $route->post('/delete', [AuthWebhookController::class, 'delete']);
    });
});

$middleware->create(['middleware' => [AuthMiddleware::class]], static function () use ($route): void {
    $route->get('/dashboard', [UserController::class, 'dashboard']);
    $route->get('/installation', [UserController::class, 'installation']);
});

$middleware->create(['prefix' => '/api', 'middleware' => [AuthKeyMiddleware::class]], static function () use ($route, $middleware): void {
    $route->get('', [EntriesController::class, 'index']);

    $middleware->create(['middleware' => [JsonMiddleware::class]], static function () use ($route): void {
        $route->post('', [EntriesController::class, 'create']);
    });
});
