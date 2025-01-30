<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    //
    use HasFactory;

    protected $primaryKey = 'RegisterID'; // กำหนด Primary Key

    protected $fillable = [
        'StudentID',
        'CourseID',
        'RegisterDate',
        'Grade',
    ];

    // ความสัมพันธ์กับ Student
    public function student()
    {
        return $this->belongsTo(Student::class, 'StudentID', 'StudentID');
    }

    // ความสัมพันธ์กับ Course
    public function course()
    {
        return $this->belongsTo(Course::class, 'CourseID', 'CourseID');
    }
}