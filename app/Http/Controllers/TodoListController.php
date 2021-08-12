<?php

namespace App\Http\Controllers;

use App\Models\Todolist;
use Illuminate\Support\Facades\Auth;

class TodoListController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $tasks = Todolist::all();
        return view('home', compact('user', 'tasks'));
    }

    public function create()
    {
        $this->validate(request(), [
            'task_name' => ['required', 'string', 'max:255'],
        ]);
        $todolist = Todolist::create([
            'task_name' => request()->task_name
        ]);

        return redirect('/')->with('status', 'Successfully Created Task!');
    }

    public function update()
    {
        $this->validate(request(), [
            'task_name' => ['required', 'string', 'max:255'],
            'task_id' => ['required'],
        ]);
        $task = Todolist::where('task_id', request()->task_id)->firstOrFail();
        $task->task_name = request()->task_name;
        $task->save();

        return redirect('/')->with('status', 'Successfully Updated Task!');
    }

    public function delete()
    {
        $this->validate(request(), [
            'task_id' => ['required'],
        ]);
        $task = Todolist::where('task_id', request()->task_id)->firstOrFail();
        $task->delete();

        return redirect('/')->with('status', 'Successfully Deleted Task!');
    }
}
