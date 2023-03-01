<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'request_type';

    protected $guarded = ['id'];

    protected $fillable = ['request_type', 'approval_id'];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function request()
    {
        return $this->hasMany(Request::class);
    }

    public function approval()
    {
        return $this->belongsTo(User::class);
    }

}
