<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // GET all students
    public function index()
    {
        return Student::with('section')->get();
    }

     public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'gender' => 'required|string',
            'section_id' => 'required|exists:sections,id',
        ]);

        $student = Student::create([
            'name' => $request->name,
            'gender' => $request->gender,
            'section_id' => $request->section_id,
        ]);

        return response()->json($student);
    }

    // ✅ UPDATE STUDENT
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $student->update([
            'name' => $request->name,
            'gender' => $request->gender
        ]);

        return response()->json($student);
    }

    // ✅ DELETE STUDENT
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return response()->json([
            'message' => 'Student deleted successfully'
        ]);
    }

    public function getStudents($id)
    {
        $students = Student::where('section_id', $id)
            ->orderByRaw("FIELD(gender, 'Male', 'Female')") // Male first, then Female
            ->orderBy('name', 'asc') // alphabetical inside each gender
            ->get();

        return response()->json($students);
    }

    // ✅ GET TOTAL STUDENTS
    public function totalStudents()
    {
        $total = Student::count();

        return response()->json([
            'total_students' => $total
        ]);
    }

    

}
