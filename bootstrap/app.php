<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Vercel Serverless Read-only fix (Storage path ን ወደ /tmp መቀየር)
$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

// ይህ መስመር Vercel Read-only Storage ችግርን ለአንዴና ለመጨረሻ ጊዜ ይፈታል
$app->useStoragePath('/tmp/storage');

return $app;
