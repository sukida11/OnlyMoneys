<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function MongoDB\BSON\toJSON;

class Post extends Model
{

    use HasFactory;
    protected $guarded = false;
    protected $table = 'posts';

    public const COUNT_CONTENT_PER_PAGE = 2;

    const PAID = 1;
    const FREE = 0;

    static public function getPostStatus() {
        return [
            self::PAID => 'Платный',
            self::FREE => 'Бесплатный'
        ];
    }

    public function images() {
        return $this->hasMany(PostImage::class, 'post_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
