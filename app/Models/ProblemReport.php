<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProblemReport extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'problem_report';

    protected $guarded = ['id'];

    protected $fillable = ['user_id', 'date', 'title', 'description', 'status', 'scheduled_at', 'status_client', 'closed_by', 'closed_at'];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getUsername()
    {
        $user_id = $this->user_id;
        $username = User::where('id', $user_id)->get('fullname');

        $parsedData = json_decode($username, true);
        $fullname = $parsedData[0]["fullname"];

        return $fullname;
    }

    public function getClosedByname()
    {
        $user_id = $this->closed_by;
        $username = User::where('id', $user_id)->get('fullname');

        $parsedData = json_decode($username, true);
        $fullname = $parsedData[0]["fullname"];

        return $fullname;
    }

}
