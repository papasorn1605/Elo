<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    use HasFactory;

    // กำหนดชื่อของตารางถ้าตารางไม่ใช้รูปแบบปกติ
    protected $table = 'students';

    // กำหนด Primary Key
    protected $primaryKey = 'StudentID';

    // กำหนดฟิลด์ที่สามารถถูกกรอกได้ (fillable)
    protected $fillable = [
        'StudentName',
        'Major',
        'Email',
        'Phone',
    ];

    // ถ้าต้องการไม่ใช้ timestamps สามารถตั้งค่าเป็น false
    public $timestamps = true;
}