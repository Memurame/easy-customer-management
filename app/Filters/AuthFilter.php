<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $allowed_ip = ['127.0.0.1', '::1'];

        if (! in_array($_SERVER['REMOTE_ADDR'], $allowed_ip)) {
            return redirect()->route('home');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
	{

	}
}