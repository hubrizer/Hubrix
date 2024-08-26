<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostMeta extends Model
{
    // Specify the table name if it doesn't follow Laravel's naming convention
    protected $table = 'postmeta';

    // If the table doesn't have timestamps (created_at, updated_at) columns
    public $timestamps = false;

    // Define the primary key if it's not 'id'
    protected $primaryKey = 'meta_id';

    // Define the fillable or guarded attributes
    protected $fillable = ['post_id', 'meta_key', 'meta_value'];

    // Optionally, define any relationships if needed
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}