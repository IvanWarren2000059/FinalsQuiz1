<?php

namespace App\Models;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['post_id', 'user_id', 'comment'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';

    protected $fillable = ['post_id', 'user_id', 'comment'];


    public function post(): BelongsTo
    {
        return $this->BelongsTo(Post::class);
    }

    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

>>>>>>> b22ed6f2b4912c22d2366baeb81eb9dfd8f34101
}
