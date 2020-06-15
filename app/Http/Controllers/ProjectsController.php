<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Project;
use Illuminate\Http\Request;
use App\Repositories\ProjectsRepository;
use Carbon\Carbon;

class ProjectsController extends Controller
{
    protected $repo;

    public function __construct(ProjectsRepository $repo)
    {
        $this->repo = $repo;
        $this->middleware('auth');

    }


    //增
    public function store(CreateProjectRequest $request)
    {
        $this->repo->create($request);
        return back();
    }
    //改
    public function update(UpdateProjectRequest $request, $id)
    {
        $this->repo->update($request,$id);
        return back();
    }
    // 删
    public function destroy($id)
    {
        $this->repo->delete($id);
        return back();
    }
    //查
    public function show(Project $project)
    {
        // return Carbon::createFromDate(1995,9,1)->addYears(1);
        // $project = $this->repo->find($id);
        $todos = $this->repo->todos($project);
        $dones = $this->repo->dones($project);
        $projects = request()->user()->projects()->pluck('name','id');
        // $todoCount = $project->tasks()->where('completion',0)->count();
        // // dd($todoCount);
        return view('projects._show',compact('project','todos','dones','projects'));
    }

    public function index()
    {
        // $projects = $this->repo->list();
        $projects = $this->repo->list();
        return view('welcome',compact('projects'));
    }
}
