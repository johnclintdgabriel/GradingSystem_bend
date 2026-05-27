<?php

namespace App\Http\Controllers;

use App\Models\TeacherAssignment;
use Illuminate\Http\Request;

class TeacherAssignmentController extends Controller
{
    // =========================
    // GET ALL ASSIGNMENTS
    // =========================
    public function index(Request $request)
    {
        $query = TeacherAssignment::with(['teacher', 'subject', 'section']);

        return $query->paginate(10);
    }

    // =========================
    // STORE ASSIGNMENT
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'section_id' => 'required|exists:sections,id',
            'grade_level' => 'required|string'
        ]);

        // prevent duplicate
        $exists = TeacherAssignment::where([
            'teacher_id' => $request->teacher_id,
            'subject_id' => $request->subject_id,
            'section_id' => $request->section_id,
            'grade_level' => $request->grade_level,
        ])->exists();

        if ($exists) {
            return response()->json([
                'message' => 'This assignment already exists'
            ], 409);
        }

        TeacherAssignment::create($request->all());

        return response()->json([
            'message' => 'Assignment created successfully'
        ], 201);
    }

    // =========================
    // UPDATE ASSIGNMENT
    // =========================
    public function update(Request $request, $id)
    {
        $assignment = TeacherAssignment::findOrFail($id);

        $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'section_id' => 'required|exists:sections,id',
            'grade_level' => 'required|string'
        ]);

        $assignment->update($request->all());

        return response()->json([
            'message' => 'Assignment updated successfully'
        ]);
    }

    // =========================
    // DELETE ASSIGNMENT
    // =========================
    public function destroy($id)
    {
        TeacherAssignment::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Assignment deleted successfully'
        ]);
    }
}
