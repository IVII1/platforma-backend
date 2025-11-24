<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttachmentRequest;
use App\Models\Attachment;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        if (request()->hasFile('attachment')) {
            $attachmentFilePath = $request->file('attachment')->storeAs(
                Str::slug($module->title) . '_attachments',
                $params['attachment_name'] . '.' . $request->file('attachment')->getClientOriginalExtension(),
                'public'
            );
            $params['attachment_file_path'] = $attachmentFilePath;
        }
        $attachment = Attachment::create([
            'module_id' => $module->id,
            'attachment_path' => $params['attachment_file_path'],
            'attachment_type' => $params['attachment_type'],
            'attachment_name' => $params['attachment_name'],
            'article_content' => $params['article_content'],
            'position' => (Module::where('subject_id', $module->id)->max('position') ?? 0) + 1,
        ]);
        return $attachment;
    }

    /**
     * Display the specified resource.
     */
    public function show(Attachment $attachment)
    {
        return $attachment;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AttachmentRequest $request, Attachment $attachment)
    {
        $attachment->load('module');
        $params = $request->validated();
        if ($request->hasFile('attachment')) {
            if ($attachment->attachment) {
                Storage::disk('public')->delete($attachment->attachment);
            }
            $file = $request->file('attachment');
            $directory = Str::slug($attachment->module->title) . '-attachments';
            $filename = Str::slug($params['attachment_name']) . '.' . $file->getClientOriginalExtension();

            $attachmentFilePath = $file->storeAs($directory, $filename, 'public');
            $params['attachment_path'] = $attachmentFilePath;

            $attachment->update($params);
            return $attachment;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attachment $attachment)
    {
        //
    }
}
