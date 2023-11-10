<?php

namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
class Home extends BaseController
{
    use ResponseTrait;
    public function index(): string
    {
        return view('welcome_message');
    }

    public function cors() {
        $this->response->setStatusCode(200);
        return $this->response
        ->setHeader('Access-Control-Allow-Origin', '*')
        ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE')
        ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
        ->setHeader('Access-Control-Allow-Credentials', 'true');
    }
}
