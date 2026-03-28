<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    // GET all sections
    public function index()
    {
        $sections = Section::with('adviser')->get();
        return response()->json($sections);
    }

    // CREATE section
    public function store(Request $request)
    {
        $request->validate([
            'grade_level' => 'required|string|max:50',
            'name' => 'required|string|max:100',
            'adviser_id' => 'required|exists:users,id',
        ]);

        $section = Section::create($request->all());

        return response()->json([
            'message' => 'Section created successfully',
            'data' => $section->load('adviser')
        ], 201);
    }

    // SHOW single section
    public function show($id)
    {
        $section = Section::with('adviser')->find($id);
        if (!$section) return response()->json(['message' => 'Section not found'], 404);

        return response()->json($section);
    }

    // UPDATE section
    public function update(Request $request, $id)
    {
        $section = Section::find($id);
        if (!$section) return response()->json(['message' => 'Section not found'], 404);

        $request->validate([
            'grade_level' => 'required|string|max:50',
            'name' => 'required|string|max:100',
            'adviser_id' => 'required|exists:users,id',
        ]);

        $section->update($request->all());

        return response()->json([
            'message' => 'Section updated successfully',
            'data' => $section->load('adviser')
        ]);
    }

    // DELETE section
    public function destroy($id)
    {
        $section = Section::find($id);
        if (!$section) return response()->json(['message' => 'Section not found'], 404);

        $section->delete();
        return response()->json(['message' => 'Section deleted successfully']);
    }

    public function assignTeacher(Request $request, $id)
    {
        $section = Section::find($id);
        if (!$section) return response()->json(['message' => 'Section not found'], 404);

        $request->validate([
            'subject' => 'required|string|max:50',
        ]);

        $user = Auth::user(); // Teacher assigning themselves

        $section->teacher_id = $user->id;
        $section->subject = $request->subject;
        $section->save();

        return response()->json(['message' => 'Teacher assigned successfully', 'section' => $section]);
    }

}
