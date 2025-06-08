<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;

class Classroom
{
    // Fake database
    protected static $data = [
        'students' => [
            ['name' => 'John Doe', 'age' => 20, 'id' => 1],
            ['name' => 'Jane Smith', 'age' => 22, 'id' => 2],
            ['name' => 'Sam Brown', 'age' => 19, 'id' => 3],
        ],
        'teachers' => [
            ['name' => 'KSDsfsf', 'subject' => 'Math', 'id' => 1],
            ['name' => 'Ms. Johnson', 'subject' => 'Science', 'id' => 2],
            ['name' => 'Mrs. Brown', 'subject' => 'English', 'id' => 3]
        ]
    ];

    public static function getStudents()
    {
        return self::$data['students'];
    }

    public static function getTeachers()
    {
        return self::$data['teachers'];
    }

    public static function getStudentById($id)
    {
        foreach (self::$data['students'] as $student) {
            if ($student['id'] == $id) {
                return $student;
            }
        }
        return null;
    }

    public static function deleteStudent($id)
    {
        foreach (self::$data['students'] as $key => $student) {
            if ($student['id'] == $id) {
                unset(self::$data['students'][$key]);
                self::$data['students'] = array_values(self::$data['students']);
                return true;
            }
        }
        return false;
    }

    public static function addStudent($student)
    {
        self::$data['students'][] = $student;
        return true;
    }

    public static function updateStudent($id, $data)
    {
        foreach (self::$data['students'] as $key => $student) {
            if ($student['id'] == $id) {
                self::$data['students'][$key] = array_merge($student, $data);
                return true;
            }
        }
        return false;
    }

    public static function getTeacherById($id)
    {
        foreach (self::$data['teachers'] as $teacher) {
            if ($teacher['id'] == $id) {
                return $teacher;
            }
        }
        return null;
    }

    public static function deleteTeacher($id)
    {
        foreach (self::$data['teachers'] as $key => $teacher) {
            if ($teacher['id'] == $id) {
                unset(self::$data['teachers'][$key]);
                self::$data['teachers'] = array_values(self::$data['teachers']);
                return true;
            }
        }
        return false;
    }

    public static function addTeacher($teacher)
    {
        self::$data['teachers'][] = $teacher;
        return true;
    }

    public static function updateTeacher($id, $data)
    {
        foreach (self::$data['teachers'] as $key => $teacher) {
            if ($teacher['id'] == $id) {
                self::$data['teachers'][$key] = array_merge($teacher, $data);
                return true;
            }
        }
        return false;
    }
}