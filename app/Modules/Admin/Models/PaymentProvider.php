<?php

namespace App\Modules\Admin\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use ReflectionClass;

class PaymentProvider extends Model
{
    use CrudTrait;
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'payment_providers';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    // get options for gateway_class enum field daynamically from the namespace App\Modules\Payments\Gateways
    public static function getGatewayClassOptions(): array
    {
        $options = [];

        $namespace = 'App\\Modules\\Payments\\Gateways';
        $path = app_path('Modules/Payments/Gateways');

        if (!is_dir($path)) {
            return $options;
        }

        foreach (glob($path . '/*.php') as $file) {
            $className = pathinfo($file, PATHINFO_FILENAME);
            $fullClassName = $namespace . '\\' . $className;

            if (!class_exists($fullClassName)) {
                continue;
            }

            $reflection = new ReflectionClass($fullClassName);

            if (
                $reflection->isAbstract() ||
                $reflection->isInterface() ||
                $reflection->getShortName() === 'Gateway'
            ) {
                continue;
            }

            $options[$fullClassName] = Str::headline($className);
        }

        return $options;
    }


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
