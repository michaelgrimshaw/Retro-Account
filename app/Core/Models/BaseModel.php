<?php

namespace App\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseModel
 *
 * @package App\Core\Models
 */
class BaseModel extends Model
{
    use HasFactory;

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        $factory = 'Database\Factories\\' . (new \ReflectionClass(get_called_class()))->getShortName() . 'Factory';
        return $factory::new();
    }
}
