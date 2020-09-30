<?php

namespace App\Service;

class BaseService
{
    public function __construct()
    {
        helper('cookie');
        helper('session');
        helper('text');
        helper("url");
        helper("utils");
    }
}