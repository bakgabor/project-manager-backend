<?php

namespace App\Services\Helpers;

class NameGenerator
{

    public function generate($name)
    {
        $name = strtolower($name);

        if (is_numeric($name[0])) $name = substr($name, 1);

        $name = str_replace(' ', '_', $name);

        $pattern = '~([^\w])+~isuD';
        $name = preg_replace($pattern, '',$name);

        return $name;
    }


}