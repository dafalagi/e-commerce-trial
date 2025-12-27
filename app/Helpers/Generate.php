<?php

use Illuminate\Support\Str;

if (!function_exists('generate_money_format'))
{
    function generate_money_format($value = 0, $currency = 'Rp.')
    {
        return $currency . ' ' . number_format($value, 0, '', '.') . ',-';
    }
}

if (!function_exists('generate_uuid'))
{
    function generate_uuid()
    {
        $uuid = Str::uuid7();
        return $uuid->toString();
    }
}

if (!function_exists('generate_random_string'))
{
    function generate_random_string($length = 10)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if (!function_exists('generate_to_snake_case'))
{
    function generate_to_snake_case($input)
    {
        $input = preg_replace('/[^\w]+/', '_', $input);

        $input = preg_replace('/(.)(?=[A-Z])/', '$1_', $input);

        $input = strtolower($input);

        $input = preg_replace('/_+/', '_', $input);

        return trim($input, '_');
    }
}

if (!function_exists('generate_order_number'))
{
    function generate_order_number($id,$count_zero = 5)
    {
        return str_pad($id, $count_zero , '0', STR_PAD_LEFT);
    }
}

if (!function_exists('re_number_format'))
{
    function re_number_format($value, $saparator = ",") {
        $clean_string = preg_replace('/([^0-9\.,-])/i', '', $value);
        $only_number_string = preg_replace('/([^0-9-])/i', '', $value);

        $separators_count_to_be_erased = strlen($clean_string) - strlen($only_number_string) - 1;

        $string_with_comma_or_dot = preg_replace('/([,\.])/', '', $clean_string, $separators_count_to_be_erased);
        $removed_thousand_separator = preg_replace('/(\.|,)(?=[0-9]{3,}$)/', '',  $string_with_comma_or_dot);

        return (float) str_replace(',', '.', $removed_thousand_separator);
    }
}

if (!function_exists('generateThrowErrorMessage')) {
    /**
     * Get icon
     *
     * @param $path
     *
     * @return string
     */
    function generateThrowErrorMessage($ex, $forDev = false)
    {
        if (env('APP_DEBUG') || $forDev)
            return 'Caught exception: "' . $ex->getMessage() . '" on line ' . $ex->getLine() . ' of ' . $ex->getFile();
        else
            return $ex->getMessage();
    }
}
