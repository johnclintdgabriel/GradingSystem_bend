<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Student;

class GradeController extends Controller
{
    /**
     * Fetch saved grades ONLY for the selected teacher assignment and quarter context.
     */
    public function index(Request $request)
    {
        $request->validate([
            'assignment_id' => 'required',
            'quarter'       => 'required|string',
        ]);

        $assignmentId = $request->input('assignment_id');
        $quarter      = $request->input('quarter');

        // ISOLATION LAYER: Force SQL to only look at records for this specific area context
        $grades = Grade::with('student')
            ->where('assignment_id', $assignmentId)
            ->where('quarter', $quarter)
            ->get();

        return response()->json($grades);
    }

    /**
     * Store or update bulk records isolated completely to this subject allocation.
     */
    public function bulkStore(Request $request)
    {
        $request->validate([
            'assignment_id'       => 'required',
            'quarter'             => 'required|string',
            'highest_scores'      => 'required|array', 
            'grades'              => 'required|array',
            'grades.*.student_id' => 'required'
        ]);

        $assignmentId  = $request->input('assignment_id');
        $quarter       = $request->input('quarter');
        $highestScores = $request->input('highest_scores');
        $gradesData    = $request->input('grades');

        // 1. Upsert Highest Possible Score (HPS) Row specifically for this assignment context
        Grade::updateOrCreate(
            [
                'student_id'    => 0, // Meta row placeholder tag
                'assignment_id' => $assignmentId,
                'quarter'       => $quarter
            ],
            [
                'scores' => [
                    'is_hps'       => true,
                    'quiz1'        => $highestScores['quiz1'] ?? 0,
                    'quiz2'        => $highestScores['quiz2'] ?? 0,
                    'recitation'   => $highestScores['recitation'] ?? 0,
                    'quiz4'        => $highestScores['quiz4'] ?? 0,
                    'quiz5'        => $highestScores['quiz5'] ?? 0,
                    'quiz6'        => $highestScores['quiz6'] ?? 0,
                    'ww_total'     => $highestScores['ww_total'] ?? 0,
                    'pt1'          => $highestScores['pt1'] ?? 0,
                    'pt2'          => $highestScores['pt2'] ?? 0,
                    'pt3'          => $highestScores['pt3'] ?? 0,
                    'pt4'          => $highestScores['pt4'] ?? 0,
                    'pt5'          => $highestScores['pt5'] ?? 0,
                    'pt6'          => $highestScores['pt6'] ?? 0,
                    'pt_total'     => $highestScores['pt_total'] ?? 0,
                    'exam'         => $highestScores['exam'] ?? 0,
                ]
            ]
        );

        // 2. Upsert Individual Student Records locked to this specific area context
        foreach ($gradesData as $gradeItem) {
            $scores = [
                'quiz1'      => $gradeItem['quiz1'] ?? 0,
                'quiz2'      => $gradeItem['quiz2'] ?? 0,
                'recitation' => $gradeItem['recitation'] ?? 0,
                'quiz4'      => $gradeItem['quiz4'] ?? 0,
                'quiz5'      => $gradeItem['quiz5'] ?? 0,
                'quiz6'      => $gradeItem['quiz6'] ?? 0,
                'pt1'        => $gradeItem['pt1'] ?? 0,
                'pt2'        => $gradeItem['pt2'] ?? 0,
                'pt3'        => $gradeItem['pt3'] ?? 0,
                'pt4'        => $gradeItem['pt4'] ?? 0,
                'pt5'        => $gradeItem['pt5'] ?? 0,
                'pt6'        => $gradeItem['pt6'] ?? 0,
                'exam'       => $gradeItem['exam'] ?? 0,
            ];

            Grade::updateOrCreate(
                [
                    'student_id'    => $gradeItem['student_id'],
                    'assignment_id' => $assignmentId,
                    'quarter'       => $quarter
                ],
                [
                    'scores' => $scores
                ]
            );
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Bulk grades safely isolated and stored.'
        ]);
    }
}