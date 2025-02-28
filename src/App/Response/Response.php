<?php
namespace App\Response;

interface Response 
{
    public function mount(int $statusCode, array $data);
}