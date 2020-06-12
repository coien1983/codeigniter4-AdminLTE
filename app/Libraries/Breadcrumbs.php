<?php

namespace App\Libraries;

class Breadcrumbs
{

    private $breadcrumbs = array();

    public function __construct()
    {
        $breadcrumb = config("Breadcrumb");

        $this->breadcrumb_open = $breadcrumb->breadcrumb_open;
        $this->breadcrumb_close = $breadcrumb->breadcrumb_close;
        $this->breadcrumb_el_open = $breadcrumb->breadcrumb_el_open;
        $this->breadcrumb_el_close = $breadcrumb->breadcrumb_el_close;
        $this->breadcrumb_el_first = $breadcrumb->breadcrumb_el_first;
        $this->breadcrumb_el_last_open = $breadcrumb->breadcrumb_el_last;
    }


    function array_sorter($key)
    {
        return function ($a, $b) use ($key) {
            return strnatcmp($a[$key], $b[$key]);
        };
    }


    function push($id, $page, $url)
    {
        if (!$page OR !$url) return;

        $url = site_url($url);

        $this->breadcrumbs[$url] = array('id' => $id, 'page' => $page, 'href' => $url);
    }


    function unshift($id, $page, $url)
    {
        if (!$page OR !$url) return;

        $url = site_url($url);

        array_unshift($this->breadcrumbs, array('id' => $id, 'page' => $page, 'href' => $url));
    }


    function show()
    {
        if ($this->breadcrumbs) {
            $output = $this->breadcrumb_open . "\n";

            usort($this->breadcrumbs, $this->array_sorter('id'));

            foreach ($this->breadcrumbs as $key => $value) {
                $keys = array_keys($this->breadcrumbs);

                if (reset($keys) == $key) {
                    $output .= "\t\t\t" . $this->breadcrumb_el_open . '<a href="' . $value['href'] . '">' . $this->breadcrumb_el_first . ' ' . $value['page'] . '</a> >' . $this->breadcrumb_el_close . "\n";
                } elseif (end($keys) == $key) {
                    $output .= "\t\t\t" . $this->breadcrumb_el_last_open . $value['page'] . $this->breadcrumb_el_close . "\n";
                } else {
                    $output .= "\t\t\t" . $this->breadcrumb_el_open . '<a href="' . $value['href'] . '">' . $value['page'] . '</a> >' . $this->breadcrumb_el_close . "\n";
                }
            }

            return $output . "\t\t\t" . $this->breadcrumb_close . "\n";
        }

        return NULL;
    }

}
