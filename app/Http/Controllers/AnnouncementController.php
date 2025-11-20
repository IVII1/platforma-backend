<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnnouncementRequest;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $announcements = Announcement::all();
        $announcements->load('user');
        return $announcements;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AnnouncementRequest $request)
    {

        $params = $request->validated();
        $userId = Auth::id();
        $announcement = Announcement::create([
            'title' => $params['title'],
            'body' => $params['body'],
            'user_id' => $userId,
            'subject_id' => null
        ]);

        return $announcement;
    }

    /**
     * Display the specified resource.
     */
    public function show(Announcement $announcement)
    {
        $announcement->load(['user', 'subject']);
        return $announcement;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AnnouncementRequest $request, Announcement $announcement)
    {
        $params = $request->validated();
        $announcement->update($params);
        $announcement->load('user', 'subjcct');
        return $announcement;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return response()->json(['message' => 'announcement deleted successfully!']);
    }
}
