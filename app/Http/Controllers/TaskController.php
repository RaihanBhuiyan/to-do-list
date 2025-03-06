<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(): JsonResponse
    {
        // Fetch tasks for the authenticated user, including the description
        return response()->json(Auth::user()->tasks);
    }

    public function store(Request $request): JsonResponse
    {
        // Validate the input, including description
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',  // Make sure description is validated
            'is_completed' => 'boolean',
        ]);

        // Create the task for the authenticated user, including description
        $task = Auth::user()->tasks()->create($validated);

        return response()->json($task, 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        // Find the task and ensure it belongs to the authenticated user
        $task = Task::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Update task with the provided data, including description
        $task->update([
            'title' => $request->input('title', $task->title),  // Update title if provided
            'description' => $request->input('description', $task->description),  // Update description if provided
            'is_completed' => $request->boolean('is_completed', $task->is_completed),  // Update is_completed status
        ]);

        return response()->json($task);
    }

    public function destroy($id): JsonResponse
    {
        // Ensure the task belongs to the authenticated user before deleting
        $task = Task::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Delete the task
        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
