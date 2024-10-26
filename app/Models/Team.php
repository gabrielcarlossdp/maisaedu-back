<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'creator_id'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function students()
    {
        return $this->hasManyThrough(Student::class, TeamStudentAssociation::class, 'team_id', 'id', 'id', 'student_id');
    }

    public function associations()
    {
        return $this->hasMany(TeamStudentAssociation::class);
    }
}
