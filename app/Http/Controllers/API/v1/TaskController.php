<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function response;
use App\Models\Task;
use Symfony\Component\HttpFoundation\Response;
use function auth;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    public function index()
    {
//        $tasks= Auth::user()->tasks();// relationship
//        $tasks = Task::where('author_id', Auth::id())->get();
        $tasks = Auth::user()->tasks; //collection

        return response()->json($tasks, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'body'  => ['required'],
        ]);
        $task = auth()->user()->addTask([
            'title' => $request->get('title'),
            'body'  => $request->get('body'),
        ]);

        return response()->json($task, Response::HTTP_CREATED);
    }

    public function update(Task $task, Request $request)
    {
        $task->update($request->all());

        return response()->json('task updated.', Response::HTTP_OK);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json('task deleted.', Response::HTTP_OK);
    }
}
