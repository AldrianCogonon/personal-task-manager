<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::latest()->get();

        $pendingTasks = $tasks
            ->where('status', 'pending')
            ->sortBy(function ($task) {
                return $task->due_date ?? '9999-12-31';
            })
            ->take(6);

        return view('tasks.index', compact('tasks', 'pendingTasks'));
    }
    public function allTasks()
    {
        $tasks = Task::latest()->get();

        return view('tasks.all_tasks', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_name' => 'required|max:255',
            'description' => 'nullable',
            'status' => 'required|in:pending,completed',
            'due_date' => 'nullable|date',
        ]);

        if(Task::count() === 0)
        {
                DB::statement('ALTER TABLE tasks AUTO_INCREMENT = 1');
        }
        Task::create($validated);

        return redirect()
            ->route('tasks.all')
            ->with('success', 'Task created successfully!');
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'task_name' => 'required|max:255',
            'description' => 'nullable',
            'status' => 'required|in:pending,completed',
            'due_date' => 'nullable|date',
        ]);

        $task->update($validated);

        return redirect()
            ->route('tasks.all')
            ->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        if (Task::count() === 0) {
            DB::statement('ALTER TABLE tasks AUTO_INCREMENT = 1');
        }
        return redirect()
            ->route('tasks.all')
            ->with('success', 'Task deleted successfully!');
    }

    public function updateStatus(Task $task)
    {
        $task->update([
            'status' => $task->status === 'pending'
                ? 'completed'
                : 'pending',
        ]);

        return redirect()
            ->route('tasks.all')
            ->with('success', 'Task status updated!');
    }
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }
    public function search(Request $request)
    {
        $search = trim($request->input('q', ''));

        $tasks = Task::where('task_name', 'like', '%' . $search . '%')
            ->latest()
            ->get();

        return response()->json(
            $tasks->map(function ($task) {
                return [
                    'id' => $task->id,
                    'task_name' => $task->task_name,
                    'description' => $task->description,
                    'status' => $task->status,
                    'due_date' => $task->due_date,
                    'url' => route('tasks.show', $task->id),
                ];
            })
        );
    }
}