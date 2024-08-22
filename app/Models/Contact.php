<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use WC_Product;

class Contact extends Model
{
    use SoftDeletes;

    protected $table = 'my_plugin_contacts';  // Specify the table name

    protected $dates = ['deleted_at'];  // To enable SoftDeletes

    protected $fillable = [

        // Add other fillable fields
    ];


}
