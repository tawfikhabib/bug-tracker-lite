<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bug;

class BugController extends Controller
{
    public function index()
    {
        return Bug::with('project', 'assignee')->latest()->paginate(10);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'status' => 'required|in:open,in_progress,closed',
            'priority' => 'required|in:low,medium,high',
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        return Bug::create($data);
    }

    public function destroy(Bug $bug)
    {
        $bug->delete();
        return response()->json(['message' => 'Bug deleted']);
    }

    public function update(Request $request, Bug $bug)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'status' => 'required|in:open,in_progress,closed',
            'priority' => 'required|in:low,medium,high',
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $bug->update($data);
        return $bug;
    }

}
