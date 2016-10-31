<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Config;
use App\Project;
use App\User;

class ProjectController extends Controller
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
  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function getProject()
  {
      $projects = Auth::user()->owns()->get();
      return view('/project/list',compact('projects'));
  }

  public function createProject(Request $request)
  {
    Project::create([
            'name' => Input::get("name"),
            'user_id' => Auth::user()->id,
            'description' => Input::get("description"),
            'language' => Input::get("language"),
            'version' => Input::get("version"),
        ]);
    return ProjectController::getProject();
  }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAddProjectForm()
    {
        return view('/project/add');
    }
}