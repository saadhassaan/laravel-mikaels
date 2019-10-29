<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $comment
 * @property int $post_id
 * @property int $user_id
 * @property string $created_at
 * @property string $updated_at
 * @property Post[] $post
 * @property User[] $user
 */
class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'post_id',
        'comment',
    ];
}
