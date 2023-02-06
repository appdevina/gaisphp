<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'fullname',
        'password',
        'area_id',
        'badan_usaha_id',
        'divisi_id',
        'role_id',
        'profile_picture',
        'approval_id',
        'notif_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function division()
    {
        return $this->belongsTo(Divisi::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function badan_usaha()
    {
        return $this->belongsTo(BadanUsaha::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function request_type()
    {
        return $this->belongsTo(RequestType::class);
    }

    public function approval()
    {
        $approval_id = $this->approval_id;
        $approval_name = User::where('id', $approval_id)->get('fullname');

        $parsedData = json_decode($approval_name, true);
        $fullname = $parsedData[0]["fullname"];

        return $fullname;
    }

    public function getDivision()
    {
        $divisi_id = $this->divisi_id;
        $division = Divisi::where('id', $divisi_id)->get('division');

        $parsedData = json_decode($division, true);
        $division = $parsedData[0]["division"];

        return $division;
    }

    public function getProfilePic()
    {
        if(!$this->profile_picture){
            return asset('images/default.png');
        }

        return asset('storage/profile/'.$this->profile_picture);
    }
}
