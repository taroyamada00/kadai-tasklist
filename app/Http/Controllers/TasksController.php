<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

class TasksController extends Controller
{
    public function index()
    {
        $data = [];
        if (\Auth::check()) { // 認証済みの場合
        $user = \Auth::user();
        // ユーザの投稿の一覧を作成日時の降順で取得
        $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);
        
        $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];
        }
        //Welcomeビューでそれらを表示
        return view('welcome', $data);
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
        
        // 認証済みユーザ（閲覧者）の投稿として作成（リクエストされた値をもとに作成）
        $request->user()->tasks()->create([
            'content' => $request->content,
            'status' => $request->status,
        ]);
        
        return redirect('/');
    }

    public function show($id)
    {
        //idを検索して取得
        $task = Task::findOrFail($id);
        
        if (\Auth::id() === $task->user_id) {// 閲覧者===その投稿の所有者
            //詳細ページを表示
            return view('tasks.show', ['task' => $task,]);
        }
        //認証済みじゃない人がアクセスを試みるとトップにリダイレクト
        return redirect('/');
    }

    public function edit($id)
    {
        //idを検索して取得
        $task = Task::findOrFail($id);
        
        if (\Auth::id() === $task->user_id) {// 閲覧者===その投稿の所有者
            //編集画面を表示
            return view('tasks.edit',['task' => $task,]);
        }
        //閲覧者===その投稿の所有者でない人がアクセスを試みるとトップにリダイレクト
        return redirect('/');
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
        
        // 認証済みユーザ（閲覧者）がその投稿の所有者である場合は、投稿を更新
        if (\Auth::id() === $task->user_id) {
            $task->status = $request->status;
            $task->content = $request->content;
            $task->save();
        }
        
        return redirect('/');
    }

    public function destroy($id)
    {
        //idを検索して取得
        $task = Task::findOrFail($id);
        
        // 認証済みユーザ（閲覧者）がその投稿の所有者である場合は、投稿を削除
        if (\Auth::id() === $task->user_id) {
            $task->delete();
        }
        
        return redirect('/');
    }
}
