<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Breadcrumb extends BaseConfig
{
    /*Breadcrumbds*/
    public $breadcrumb_open = '<ol class="breadcrumb">';
    public $breadcrumb_close = '</ol>';
    public $C = '<li>';
    public $breadcrumb_el_close = "</li>";
    public $breadcrumb_el_first = "<i class=\"fa fa-dashboard\"></i>";
    public $breadcrumb_el_last = "<li class=\"active\">";
}