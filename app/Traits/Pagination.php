<?php

namespace App\Traits;

trait Pagination
{
    public function paginateData($object, $per_page, $page, $is_model = true)
    {
        if ($page < 1) {
            $page = 1;
        }
        if ($is_model) {
            return $object->skip($per_page * ($page - 1))->take($per_page);
        } else {
            $res = [];
            foreach ($object->skip($per_page * ($page - 1))->take($per_page) as $key => $value) {
                $res[] = $value;
            }

            return $data = collect($res);
        }
    }

    public function paginationDetail($per_page, $page, $count)
    {
        return [
            'data_per_page' => (int) $per_page,
            'next_page' => (int) $page + 1,
            'prev_page' => (int) $page - 1,
            'first_page' => 1,
            'last_page' => (int) number_format($count / $per_page, 0),
            'next_page_url' => url()->current() . "?per_page=" . $per_page . "&page=" . ($page + 1),
            'previous_page_url' => url()->current() . "?per_page=" . $per_page . "&page=" . ($page - 1),
            'first_page_url' => url()->current() . "?per_page=" . $per_page . "&page=1",
            'last_page_url' => url()->current()
                . "?per_page="
                . $per_page
                . "&page="
                . (number_format($count / $per_page, 0)),
            'from' => ($count > 0) ? (($page - 1) * $per_page) + 1 : 0,
            'to' => (($page - 1) * $per_page) + $per_page > $count ? $count : (($page - 1) * $per_page) + $per_page,
            'current_page' => (int) $page,
            'total_pages' => (int) ceil($count / $per_page),
            'total_data' => (int) $count
        ];
    }
}
