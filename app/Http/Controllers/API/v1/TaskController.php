<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function response;
use App\Models\Task;

class TaskController extends Controller
{

    public function store(Request $request)
    {
        $task=Task::create([
            'title'=>$request->get('title'),
            'body'=>$request->get('body')
        ]);

        return response()->json($task,201);
    }
}
