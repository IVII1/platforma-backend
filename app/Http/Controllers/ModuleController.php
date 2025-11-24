<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModuleRequest;
use App\Models\Module;
use App\Models\Subject;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $subject = $request->query('subject');
        $query = Module::query();
        if ($subject) {
            $query->where('subject_id', $subject);
        }
        $query->orderBy('position');
        return $query->paginate(20);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ModuleRequest $request, Subject $subject)
    {
        $params = $request->validated();
        $module = Module::create([
            'subject_id' => $subject->id,
            'title' => $params['title'],
            'position' => (Module::where('subject_id', $subject->id)->max('position') ?? 0) + 1,
            'is_visible' => $params['is_visible'],
        ]);
        return $module;
    }

    /**
     * Display the specified resource.
     */
    public function show(Module $module)
    {
        $module->load('attachments');
        return $module;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ModuleRequest $request, Module $module)
    {
        $params = $request->validated();
        $module->update($params);
        return $module;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Module $module)
    {
        $module->delete();
        return response()->json(['message' => 'Module deleted successfully']);
    }
}
