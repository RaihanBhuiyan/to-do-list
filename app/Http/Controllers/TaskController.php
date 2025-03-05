<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Task::all());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate(['title' => 'required|string|max:255']);
        $task = Task::create($validated);
        return response()->json($task, 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $task = Task::findOrFail($id);
        $task->update(['completed' => $request->boolean('completed')]);
        return response()->json($task);
    }

    public function destroy($id): JsonResponse
    {
        Task::destroy($id);
        return response()->json(['message' => 'Task deleted']);
    }
}
