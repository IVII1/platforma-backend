<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttachmentRequest;
use App\Models\Attachment;
use App\Models\Module;
use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Attachment::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AttachmentRequest $request, Module $module)
    {
        $params = $request->validated();
    }

    /**
     * Display the specified resource.
     */
    public function show(Attachment $attachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attachment $attachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attachment $attachment)
    {
        //
    }
}
