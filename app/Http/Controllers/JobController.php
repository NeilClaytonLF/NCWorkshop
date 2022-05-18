<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class JobController extends Controller
{
    /**
     * Home screen after logging in. Shows a kanban board of job states when visited
     *
     * @return view Jobs view
     */
    public function index()
    {
        $jobs = Job::all();
        return view('jobs.index')->with('jobs', $jobs);
    }

    public function create()
    {
        $jobStates = Job::getEnumValues('state');
        $users = User::all()->toArray();
        return view('jobs.create')->with('states', $jobStates)->with("users", $users);
    }

    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'title' => 'required|max:255',
            'state' => 'required',
            'user_id' => 'required',
        ]);
        $formValues = $request->post();
        
        Job::create([
            'title' => $formValues['title'],
            'description' => $formValues['description'],
            'state' => $formValues['state'],
            'user_id' => $formValues['user_id']
        ]);

        Session::flash('message', 'Job successfully created');
        return to_route('jobs.index');

    }

    public function show($id) 
    {
        $job = Job::findOrFail($id);
        return view('jobs.show')->with('job', $job);
    }

    public function edit($id)
    {
        $jobStates = Job::getEnumValues('state');
        $job = Job::findOrFail($id);
        $users = User::all()->toArray();
        return view('jobs.edit')->with('states', $jobStates)->with('job', $job)->with("users", $users);
    }

    public function update($id, Request $request)
    {   
        $validated = $request->validate([
            'title' => 'required|max:255',
            'state' => 'required',
            'user_id' => 'required',
        ]);
        $formValues = $request->post();
        $job = Job::findOrFail($id);
        $job->title = $formValues['title'];
        $job->description = $formValues['description'];
        $job->state = $formValues['state'];
        $job->user_id = $formValues['user_id'];
        $job->save();
        Session::flash('message', 'Job successfully Edited');
        return to_route('jobs.index');
    }

    public function destroy($id)
    {
        $job = Job::findOrFail($id);
        $job->delete();
        return to_route('jobs.index');
    }
}
