<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    // =========================
    // READ (GET ALL)
    // =========================
    public function index(Request $request)
    {
        $query = Subject::query();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        return $query->orderBy('id', 'desc')->paginate(10);
    }

    // =========================
    // CREATE (STORE)
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Subject::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'Subject created successfully'
        ], 201);
    }

    // =========================
    // READ SINGLE (optional)
    // =========================
    public function show($id)
    {
        return Subject::findOrFail($id);
    }

    // =========================
    // UPDATE
    // =========================
    public function update(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $subject->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'Subject updated successfully'
        ]);
    }

    // =========================
    // DELETE
    // =========================
    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return response()->json([
            'message' => 'Subject deleted successfully'
        ]);
    }
}
