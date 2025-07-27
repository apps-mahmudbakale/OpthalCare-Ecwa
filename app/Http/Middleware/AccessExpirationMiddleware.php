<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

class AccessExpirationMiddleware
{
  /**
   * Handle an incoming request.
   */
  public function handle(Request $request, Closure $next): Response
  {
    $expirationDate = Carbon::create(2025, 07, 25);

    if (Carbon::now()->greaterThan($expirationDate)) {
      $html = <<<HTML
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Access Denied</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
            </head>
            <body class="bg-light d-flex align-items-center" style="height: 100vh;">
                <div class="container text-center">
                    <div class="card shadow-lg border-danger">
                        <div class="card-body">
                            <h1 class="display-4 text-danger">Access Denied</h1>
                            <p class="lead">Your access to this application has expired.</p>
                            <p class="text-muted">Please contact the administrator if you believe this is a mistake.</p>
                            <a href="/" class="btn btn-primary mt-3">Go Back Home</a>
                        </div>
                    </div>
                </div>
            </body>
            </html>
            HTML;

      return new Response($html, 403);
    }

    return $next($request);
  }
}
