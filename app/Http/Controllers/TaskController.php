<?php

namespace App\Http\Controllers;

use App\Helpers\Constants;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $projects = Constants::PROJECTS;

        if (\request()->query('project_id')) {
            $tasks = Task::whereProjectId(\request()->query('project_id'))->get()->sortBy('order');
        } else {
            $tasks = Task::all()->sortBy('order');
        }


        return view('tasks.index', compact('projects', 'tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $projects = Constants::PROJECTS;

        return view('tasks.create', compact('projects'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTaskRequest $request
     * @return RedirectResponse
     */
    public function store(StoreTaskRequest $request): RedirectResponse
    {
        if (Task::create($request->all())) {
            return redirect()->route('home');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Task $task
     * @return Response
     */
    public function edit(Task $task)
    {
        $projects = Constants::PROJECTS;

        return view('tasks.edit', compact('projects', 'task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTaskRequest $request
     * @param Task $task
     * @return RedirectResponse
     */
    public function update(UpdateTaskRequest $request, Task $task) : RedirectResponse
    {
        if ($task->update($request->all())) {
            return redirect()->route('home');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Task $task
     * @return RedirectResponse
     */
    public function destroy(Task $task) : RedirectResponse
    {
        //
        if ($task->delete()) {
            return redirect()->route('home');
        }
    }

    /**
     * @param Request $request
     */

    public function tasks_order(Request $request)
    {
        $validated = $request->validate([
            'tasks' => 'required|array',
            'tasks.*.id' => 'exists:tasks',
            'tasks.*.order' => 'required',
            'tasks.*.name' => 'required',
        ]);

        Task::upsert(
            $validated['tasks']
            , ['id']);

    }
}
