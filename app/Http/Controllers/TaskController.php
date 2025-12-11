<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
 
    public function index()
    {
        $tasks = Task::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($task) {
                return [
                    'id' => $task->id,
                    'title' => $task->title,
                    'is_completed' => $task->is_completed,
                    'created_at' => $task->created_at,
                    'time_ago' => $task->created_at->diffForHumans(), // Laravel Carbon
                ];
            });

        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $task = Task::create([
            'title' => $validated['title'],
            'user_id' => auth()->id(),
            'is_completed' => false,
        ]);

        return response()->json([
            'id' => $task->id,
            'title' => $task->title,
            'is_completed' => $task->is_completed,
            'created_at' => $task->created_at,
            'time_ago' => $task->created_at->diffForHumans(),
        ], 201);
    }

    public function update(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $task->update([
            'is_completed' => !$task->is_completed,
        ]);

        return response()->json($task);
    }
}
