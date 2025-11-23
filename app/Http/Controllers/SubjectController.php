<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubjectRequest;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $semester = $request->query('semester');
        $year = $request->query('year');
        $type = $request->query('type');
        $teacher = $request->query('teacher_id');
        $assistant = $request->query('teaching_assistant_id');
        $creditsMin = $request->query('credits_min', 0);
        $creditsMax = $request->query('credits_max', 999);
        $search = $request->query('q');
        $eligible = $request->boolean('eligible_only');

        $allowedSemesters = ['winter', 'summer'];
        $allowedYears = [1, 2, 3];
        $allowedTypes = ['bachelors', 'masters'];

        $query = Subject::query();

        if ($year && in_array((int)$year, $allowedYears)) {
            $query->where('year', $year);
        }

        if ($semester && in_array($semester, $allowedSemesters)) {
            $query->where('semester', $semester);
        }

        if ($type && in_array($type, $allowedTypes)) {
            $query->where('type', $type);
        }

        $query->whereBetween('credits', [$creditsMin, $creditsMax]);

        if ($teacher) {
            $query->where('teacher_id', $teacher);
        }

        if ($assistant) {
            $query->where('teaching_assistant_id', $assistant);
        }

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($eligible == 'true') {
            $studentId = Auth::id();

            $query->where(function ($q) use ($studentId) {
                $q->whereNull('prerequisite_subject_id')
                    ->orWhereIn('prerequisite_subject_id', function ($subQuery) use ($studentId) {
                        $subQuery->select('subject_id')
                            ->from('grades')
                            ->where('student_id', $studentId)
                            ->where('has_passed', true);
                    });
            });
        }

        return $query->with('teacher', 'prerequisite', 'assistant')->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubjectRequest $request)
    {
        $params = $request->validated();
        $gradingGuideFilePath = $request->file('grading_guide')->store('grading_guides', 'public');
        $curriculumOverviewPath = $request->file('curriculum_overview')->store('curriculum_overviews', 'public');
        $params['curriculum_overview_file_path'] = $curriculumOverviewPath;
        $params['grading_guide_file_path'] = $gradingGuideFilePath;

        $subject = Subject::create($params);
        return $subject;
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        $subject->load('teacher', 'assistant', 'prerequisite');
        return $subject;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubjectRequest $request, Subject $subject)
    {
        $params = $request->validated();
        if ($request->hasFile('grading_guide')) {
            if ($subject->grading_guide_file_path) {
                Storage::disk('public')->delete($subject->grading_guide_file_path);
            }
            $gradingGuideFilePath = $request->file('grading_guide')->store('grading_guides', 'public');
            $params['grading_guide_file_path'] = $gradingGuideFilePath;
        }
        if ($request->hasFile('curriculum_overview')) {
            if ($subject->curriculum_overview_file_path) {
                Storage::disk('public')->delete($subject->curriculum_overview_file_path);
            }
            $curriculumOverviewFilePath = $request->file('curriculum_overview')->store('curriculum_overviews', 'public');
            $params['curriculum_overview_file_path'] = $curriculumOverviewFilePath;
        }
        $subject->update($params);
        return $subject;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        if ($subject->grading_guide_file_path) {
            Storage::disk('public')->delete($subject->grading_guide_file_path);
        }
        if ($subject->curriculum_overview_file_path) {
            Storage::disk('public')->delete($subject->curriculum_overview_file_path);
        }
        $subject->delete();
        return response()->json(['message' => 'subject deleted.']);
    }
}
