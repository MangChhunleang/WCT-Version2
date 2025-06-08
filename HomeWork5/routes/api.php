<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClassroomController;

// Student routes
Route::get('/students', [ClassroomController::class, 'getAllStudents']);
Route::post('/students', [ClassroomController::class, 'createStudent']);
Route::delete('/students/{id}', [ClassroomController::class, 'deleteStudent']);
Route::patch('/students/{id}', [ClassroomController::class, 'updateStudent']);

// Teacher routes
Route::get('/teachers', [ClassroomController::class, 'getAllTeachers']);
Route::get('/teachers/{id}', [ClassroomController::class, 'getTeacherById']);
Route::post('/teachers', [ClassroomController::class, 'createTeacher']);
Route::delete('/teachers/{id}', [ClassroomController::class, 'deleteTeacher']);
Route::patch('/teachers/{id}', [ClassroomController::class, 'updateTeacher']); 