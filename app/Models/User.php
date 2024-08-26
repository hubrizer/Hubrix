<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    // Specify the table name if it doesn't follow Laravel's naming convention
    protected $table = 'users';

    protected $primaryKey = 'ID'; // WordPress uses 'ID' as the primary key

    public $timestamps = false; // WordPress doesn't use Laravel-style timestamps

    // Define the fillable attributes
    protected $fillable = [
        'user_login',
        'user_pass',
        'user_nicename',
        'user_email',
        'user_url',
        'user_registered',
        'user_activation_key',
        'user_status',
        'display_name'
    ];

    // Optionally, define any relationships with other models, such as user meta
    public function meta()
    {
        return $this->hasMany(UserMeta::class, 'user_id', 'ID');
    }
}