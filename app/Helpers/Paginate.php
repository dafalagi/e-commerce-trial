<?php

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;


if (!function_exists('paginate')) {

    function paginate($items, Array $config = []) : object
    {
        if (!is_numeric($config['length']) or !is_numeric($config['page']) )
        throw new \Exception('false data type');

        $length =  $config['length'] ?? 10;
        $page =  $config['page'] ?? 1;

        if ($items instanceof Builder ) {
            $count = $items->count();
            $data = $items->skip($length * ($page - 1))->take($length)->get();

        } else if ($items instanceof Collection) {
            $count = count($items);
            $data = $items->skip($length * ($page - 1))->take($length);

        } else {
            throw new \Exception('Data format not support',500);
        }

        return (object) [
            'data' => $data,
            'pagination' => (object) [
                'current_page' => (int) $page,
                'per_page' => (int) $length,
                'total' => (int) $count,
                'last_page' => (int) number_format(ceil((int) $count/(int) $length),0)
            ]
        ];

    }
}
