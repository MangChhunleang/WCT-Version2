<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    // Student endpoints
    public function getAllStudents()
    {
        return response()->json(Classroom::getStudents());
    }

    public function createStudent(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'age' => 'required|integer'
        ]);

        $students = Classroom::getStudents();
        $newId = count($students) > 0 ? max(array_column($students, 'id')) + 1 : 1;
        
        $newStudent = [
            'id' => $newId,
            'name' => $data['name'],
            'age' => $data['age']
        ];

        Classroom::addStudent($newStudent);
        return response()->json($newStudent, 201);
    }

    public function deleteStudent($id)
    {
        $success = Classroom::deleteStudent($id);
        if ($success) {
            return response()->json(['message' => 'Student deleted successfully']);
        }
        return response()->json(['message' => 'Student not found'], 404);
    }

    public function updateStudent(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'sometimes|string',
            'age' => 'sometimes|integer'
        ]);

        $success = Classroom::updateStudent($id, $data);
        if ($success) {
            return response()->json(['message' => 'Student updated successfully']);
        }
        return response()->json(['message' => 'Student not found'], 404);
    }

    // Teacher endpoints
    public function getAllTeachers()
    {
        return response()->json(Classroom::getTeachers());
    }

    public function getTeacherById($id)
    {
        $teacher = Classroom::getTeacherById($id);
        if ($teacher) {
            return response()->json($teacher);
        }
        return response()->json(['message' => 'Teacher not found'], 404);
    }

    public function createTeacher(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'subject' => 'required|string'
        ]);

        $teachers = Classroom::getTeachers();
        $newId = count($teachers) > 0 ? max(array_column($teachers, 'id')) + 1 : 1;
        
        $newTeacher = [
            'id' => $newId,
            'name' => $data['name'],
            'subject' => $data['subject']
        ];

        Classroom::addTeacher($newTeacher);
        return response()->json($newTeacher, 201);
    }

    public function deleteTeacher($id)
    {
        $success = Classroom::deleteTeacher($id);
        if ($success) {
            return response()->json(['message' => 'Teacher deleted successfully']);
        }
        return response()->json(['message' => 'Teacher not found'], 404);
    }

    public function updateTeacher(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'sometimes|string',
            'subject' => 'sometimes|string'
        ]);

        $success = Classroom::updateTeacher($id, $data);
        if ($success) {
            return response()->json(['message' => 'Teacher updated successfully']);
        }
        return response()->json(['message' => 'Teacher not found'], 404);
    }
} 