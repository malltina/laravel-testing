<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function response;
use App\Models\Task;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'title'=>['required'],
            'body'=>['required']
        ]);
        $task=Task::create([
            'title'=>$request->get('title'),
            'body'=>$request->get('body')
        ]);

        return response()->json($task,Response::HTTP_CREATED);
    }

    public function update(Task $task,Request $request)
    {
        $task->update($request->all());

        return response()->json('task updated.',Response::HTTP_OK);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json('task deleted.',Response::HTTP_OK);
    }
}
