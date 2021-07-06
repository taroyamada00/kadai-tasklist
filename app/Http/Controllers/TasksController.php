<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

class TasksController extends Controller
{
    // getでtasks/にアクセスされた場合の「一覧表示処理」
    public function index()
    {
        $tasks = Task::all();
        return view('tasks.index', ['tasks' => $tasks,
        ]);
    }

    public function create()
    {
        $task = new Task;
        return view('tasks.create', ['task' => $task,
        ]);
    }

    public function store(Request $request)
    {
        //バリデーション
        $request->validate([
            'status' => 'required|max:10',
            'content' => 'required|max:255',
        ]);
        
        //タスクを作成
        $task = new Task;
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();
        
        return redirect('/');
    }

    public function show($id)
    {
        //idを検索して取得
        $task = Task::findOrFail($id);
        
        return view('tasks.show', [
            'task' => $task,
        ]);
    }

    public function edit($id)
    {
        //idを検索して取得
        $task = Task::findOrFail($id);
        
        return view('tasks.edit', 
            ['task' => $task,
        ]);
    }

    public function update(Request $request, $id)
    {
        //バリデーション
        $request->validate([
            'status' => 'required|max:10',
            'content' => 'required|max:255',
        ]);
        
        //idを検索して取得
        $task = Task::findOrFail($id);
        
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();
        
        return redirect('/');
    }

    public function destroy($id)
    {
        //idを検索して取得
        $task = Task::findOrFail($id);
        
        $task->delete();
        
        return redirect('/');
    }
}
