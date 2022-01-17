<?php

namespace App\Core\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

/**
 * Class Money
 *
 * @package App\Core\Casts
 */
class Money implements CastsAttributes
{
    /**
     * Transform the attribute from the underlying model values.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     *
     * @return float
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return $value / 100;
    }


    /**
     * Transform the attribute to its underlying model values.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     *
     * @return int
     */
    public function set($model, string $key, $value, array $attributes)
    {
        return (int)$value * 100;
    }
}
