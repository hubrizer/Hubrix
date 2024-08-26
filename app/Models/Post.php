<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Specify the table name if it doesn't follow Laravel's naming convention
    protected $table = 'posts';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        global $wpdb;
        $this->table = $wpdb->prefix . 'posts'; // Dynamically set the table name
    }

    // Define the primary key if it's not 'id'
    protected $primaryKey = 'ID';

    // If the table doesn't have timestamps (created_at, updated_at) columns
    // public $timestamps = false;

    // Define the fillable or guarded attributes
    protected $fillable = [
        'post_author',
        'post_date',
        'post_date_gmt',
        'post_content',
        'post_title',
        'post_excerpt',
        'post_status',
        'comment_status',
        'ping_status',
        'post_password',
        'post_name',
        'to_ping',
        'pinged',
        'post_modified',
        'post_modified_gmt',
        'post_content_filtered',
        'post_parent',
        'guid',
        'menu_order',
        'post_type',
        'post_mime_type',
        'comment_count',
    ];

    // Define relationships if needed
    public function postMeta()
    {
        return $this->hasMany(PostMeta::class, 'post_id', 'ID');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'post_author');
    }
}