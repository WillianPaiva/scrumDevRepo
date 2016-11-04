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
        return $project->members()->get();
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
    Route::post('members/delete/{projectid}/{userid}', function($projectid, $userid) {
        $project = App\Project::find($projectid);
        $project->members()->detach($userid);
    });
    Route::post('project/delete/{projectid}', function($projectid) {
         App\Project::find($projectid)->delete();
    });
    Route::post('project/add', function(Request $request) {
        App\Project::create([
            'name' => $request->name,
            'user_id' => $request->user_id,
            'description' => $request->description,
            'language' => $request->language,
            'version' => $request->version,
        ]);

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
});

