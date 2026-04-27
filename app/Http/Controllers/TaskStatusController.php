<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskStatusRequest;
use App\Http\Requests\UpdateTaskStatusRequest;
use App\Models\TaskStatus;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TaskStatusController extends Controller
{
    public function index(): View
    {
        return view('statuses.index', ['taskStatuses' => TaskStatus::paginate(15)]);
    }

    public function create()
    {
        if (Auth::guest()) {
            abort(403);
        }
        return view('statuses.create');
    }

    public function store(StoreTaskStatusRequest $request)
    {
        if (Auth::guest()) {
            return redirect()->route('statuses.index');
        }

        $validated = $request->validated();
        $taskStatus = new TaskStatus();

        $taskStatus->fill($validated);
        $taskStatus->save();
        $message = __('controllers.task_statuses_create');
        flash($message)->success();
        return redirect()->route('statuses.index');
    }

    public function edit(TaskStatus $taskStatus)
    {
        return view('statuses.edit', compact('taskStatus'));
    }

    public function update(UpdateTaskStatusRequest $request, TaskStatus $taskStatus)
    {
        if (Auth::guest()) {
            return redirect()->route('statuses.index');
        }

        $validated = $request->validated();

        $taskStatus->fill($validated);
        $taskStatus->save();

        flash(__('controllers.task_statuses_update'))->success();
        return redirect()->route('statuses.index');
    }

    public function destroy(TaskStatus $taskStatus)
    {
        if ($taskStatus->tasks()->exists()) {
            flash(__('controllers.task_statuses_destroy_failed'))->error();
            return back();
        }
        $taskStatus->delete();

        flash(__('controllers.task_statuses_destroy'))->success();
        return redirect()->route('statuses.index');
    }
}
