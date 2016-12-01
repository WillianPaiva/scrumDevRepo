<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['middleware' => 'api'], function() {
  Route::get('members/{id}', function($id) {

    $project = App\Project::find($id);
    return Response::json($project->members()->get());
  });

  Route::get('tasks/{id}', function($id) {

    $userstory = App\UserStory::find($id);

    return Response::json($userstory->Tasks()->get());
  });
  Route::get('userlist', function(Request $request) {

    $term = $request->q;
    $results = array();
    $queries = DB::table('users')
    ->where('name', 'LIKE', '%'.$term.'%')
    ->take(5)->get();
    foreach ($queries as $query)
    {
      $results[] = [ 'id' => $query->id, 'name' => $query->name ];
    }
    return Response::json($results);

  });

  Route::post('adduser/{userid}/{projectid}', function($userid, $projectid) {
    $project = App\Project::find($projectid);
    $project->members()->attach($userid);
  });

  Route::post('userstory/setsprint/{id}/{sp}', function($id, $sp) {

    $sprint=App\Sprint::find($sp);
    $us=App\UserStory::find($id);
    $us->sprint_id=$sp;
    $us->date_begin=$sprint->date_begin;
    $us->date_estimated=$sprint->date_estimated;
    $us->save();
  });

  Route::post('members/delete/{projectid}/{userid}', function($projectid, $userid) {
    $project = App\Project::find($projectid);
    $project->members()->detach($userid);
  });
  Route::post('project/delete/{projectid}', function($projectid) {
    App\Project::find($projectid)->delete();
  });
  Route::post('us/delete/{id}', function($id) {
    App\UserStory::find($id)->delete();
  });

  Route::post('sprint/delete/{id}', function($id) {
    App\Sprint::find($id)->delete();
  });

  Route::post('project/add', function(Request $request) {
    $project = App\Project::create([
      'name' => $request->name,
      'user_id' => $request->user_id,
      'description' => $request->description,
      'language' => $request->language,
      'version' => $request->version,
    ]);
    return $project;
  });

  Route::post('us/add', function(Request $request) {
    $us = App\UserStory::create([
      'description' => $request->description,
      'status' => null,
      'commit' => null,
      'date_begin' => null,
      'date_estimated' => null,
      'date_finished' => null,
      'effort' => $request->effort,
      'priority' => $request->priority,
      'project_id' => $request->project_id,
      'sprint_id' => null,
    ]);
    return $us;
  });

  Route::post('layout/add', function(Request $request) {
    App\Layout::create([
      'name' => $request->name,
      'position' => $request->position,
      'sprint_id' => $request->sprint_id,
    ]);
  });
  Route::post('sprint/add', function(Request $request) {
    $sprint = App\Sprint::create([
      'id' => null,
      'name' => $request->name,
      'date_begin' => $request->date_begin,
      'date_estimated' => $request->date_estimated,
      'project_id' => $request->project_id,
    ]);
    App\Layout::create([
      'name' => 'TODO',
      'position' => 0,
      'sprint_id' => $sprint->id,
    ]);
    App\Layout::create([
      'name' => 'DOING',
      'position' => 1,
      'sprint_id' => $sprint->id,
    ]);
    App\Layout::create([
      'name' => 'DONE',
      'position' => 2,
      'sprint_id' => $sprint->id,
    ]);
    return $sprint;
  });

  Route::get('getownproject/{id}/{search?}', function($id, $search = null) {
    $user = App\User::find($id);
    $result = array();

    if($search == null){
      $queries = $user->owns()->get();
    }else{
      $queries = $user->owns()->where('name', 'LIKE', '%'.$search.'%')->get();
    }

    foreach ($queries as $query)
    {
      $result[] = [ 'id' => $query->id,
      'name' => $query->name,
      'description' => $query->description,
      'language' => $query->language,
      'user_id' => $query->user_id,
      'version' => $query->version,
      'username' => $user->name
    ];
  }
  return Response::json($result);

});
Route::get('getmemberproject/{id}/{search?}', function($id, $search = null) {
  $user = App\User::find($id);
  $result = array();
  if($search == null){
    $queries = $user->memberof()->get();
  }else{
    $queries = $user->memberof() ->where('name', 'LIKE', '%'.$search.'%') ->get();
  }

  foreach ($queries as $query)
  {
    $result[] = [ 'id' => $query->id,
    'name' => $query->name,
    'description' => $query->description,
    'language' => $query->language,
    'user_id' => $query->user_id,
    'version' => $query->version,
    'username' => $user->name
  ];
}
return Response::json($result);

});

Route::post('project/edit', function(Request $request) {
  $project = App\Project::find($request->id);
  $project->name = $request->name;
  $project->description = $request->description;
  $project->language = $request->language;
  $project->version = $request->version;
  $project->save();

});
Route::get('project/{id}', function($id) {
  return Response::json(App\Project::find($id));
});
// a get based on the Sprint
Route::get('layout/{id}', function($id) {
  $sprint = App\Sprint::find($id);
  $cols = $sprint->Collunms()->orderBy('position')->get();
  return Response::json($cols);
});
// a get based on the colunmns
Route::get('layoutcol/{id}',function($id){
  $cols=App\Layout::find($id);
  return Response::json($cols->get());
});
Route::get('get_tasks/{id}/{status}', function($id,$status) {
  $sprint = App\Sprint::find($id);
  $result = array();
  foreach($sprint->UserStorys()->get() as $us){
    foreach($us->Tasks()->where('status',$status)->get() as $task){
      array_push($result, $task);
    }

  }
  return Response::json($result);
});

Route::get('sprintnb/{id}', function($id){
  $sprint = App\Sprint::find($id);
  $project = App\Project::find($sprint->project);
  $list = $project->Sprints()->orderBy('created_at')->get()->pluck('id');
  $nb = array_search($id,$list);
  return $nb;
});

Route::get('backlog/{id}/{order}', function($id, $order) {
  $project = App\Project::find($id);
  return Response::json($project->UserStorys()->orderBy($order)->get());
});
Route::get('sprint/{id}/{order}', function($id, $order) {
  $project = App\Project::find($id);
  return Response::json($project->Sprints()->orderBy($order)->get());
});
Route::get('us/{id}',function($id) {
  return Response::json(App\UserStory::find($id));
});

Route::post('layout_pos/{id}/{pos}',function($id, $pos) {
  $layout = App\Layout::find($id);
  $layout->position = $pos;
  $layout->save();
});

Route::post('us/edit/',function(Request $request){
  $US=App\UserStory::find($request->id);
  $US->description=$request->description;
  $US->status=$request->status;
  $US->commit=$request->commit;
  $US->date_begin=$request->date_begin;
  $US->date_estimated=$request->date_estimated;
  $US->date_finished=$request->date_finished;
  $US->effort=$request->effort;
  $US->priority=$request->priority;
  $US->project_id=$request->project_id;
  $US->sprint_id=$request->sprint_id;
  $US->save();
});

Route::get('sprint/{id}', function($id) {
  $project = App\Project::find($id);
  return Response::json($project->Sprints()->get());
});

Route::post('updatetask/{id}/{status}', function($id, $status){
  $task = App\Task::find($id);
  $task->status = $status;
  $task->save();
});

Route::post('updateus/{id}', function($id){
  $sprint = App\Sprint::find($id);
  foreach ($sprint->UserStorys()->get() as $us) {
      foreach($us->Tasks()->get() as $task){
          if($task->status=="DONE"){
                $us->status = "DONE";
                $us->save();
           }
           else{
             $us->status = "ON GOING";
             $us->save();
             break;
           }
      }
  }
});

Route::post('task/add', function(Request $request){
  $task = App\Task::create([
    'id' => null,
    'name' => $request->name,
    'description' => $request->description,
    'status' => "TODO",
    'commit' => "",
    'priority' => $request->priority,
    'cost' => $request->cost,
    'date_begin' => "",
    'date_estimated' => "",
    'date_finished' => "",
    'user_story_id' => $request->user_story_id,
  ]);
  return $task;
});

Route::post('task/delete/{id}', function($id){
  App\Task::find($id)->delete();
});
 Route::post('layout/delete/{id}/{name}',function ($id,$name){
     App\Sprint::find($id)->Collunms()->where('name',$name)->delete();

 });
Route::get('task/{status}/{id}',function($status,$id){
$us=App\UserStory::find($id);
$result=array();
  foreach($us->Tasks()->where('status',$status)->get() as $task){
    array_push($result, $task);
  }


return Response::json($result);
});
Route::get('sprintEdit/{id}',function($id) {
  return Response::json(App\Sprint::find($id));
});
Route::post('sprint/edit/', function (Request $request){
  $Sprint=App\Sprint::find($request->id);
  $Sprint->name=$request->name;
  $Sprint->date_begin=$request->date_begin;
  $Sprint->date_estimated=$request->date_estimated;
  $Sprint->project_id=$request->project_id;
  $Sprint->save();

});


Route::get('taskEdit/{id}',function($id) {
  return Response::json(App\Task::find($id));
});

Route::post('task/edit/', function (Request $request){
  $Task=App\Task::find($request->id);
  $Task->name=$request->name;
  $Task->description=$request->description;
  $Task->status=$request->status;
  $Task->commit=$request->commit;
  $Task->priority=$request->priority;
  $Task->cost=$request->cost;
  $Task->save();

});



});
