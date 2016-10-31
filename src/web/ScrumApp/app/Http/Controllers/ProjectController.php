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
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function getProject()
  {
    $user_id = DB::table('users')->select('id')->where('name',Auth::user()->name)->pluck('id');
  	$projects = Project::where('user_id',$user_id[0])->get();
    return view('/project/list', compact('projects'));
  }

  public function createProject(Request $request)
  {
    $user_id = DB::table('users')->select('id')->where('name',Auth::user()->name)->pluck('id');
    Project::create([
            'name' => Input::get("name"),
            'user_id' => $user_id[0],
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