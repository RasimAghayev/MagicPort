<?php

namespace Tests\Unit;

use App\Http\Middleware\SecurityHeaders;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class SecurityHeadersTest extends TestCase
{
    public function test_security_headers_are_set(): void
    {
        $middleware = new SecurityHeaders();

        $request = Request::create('/');
        $response = $middleware->handle($request, fn ($req) => response('ok'));

        $this->assertSame('nosniff', $response->headers->get('X-Content-Type-Options'));
        $this->assertSame('DENY', $response->headers->get('X-Frame-Options'));
        $this->assertSame('no-referrer', $response->headers->get('Referrer-Policy'));
    }
}
