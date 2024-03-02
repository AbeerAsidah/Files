<?php

namespace App\Http\Controllers;
use JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Group;
use App\Models\User;
use App\Models\MyFile;
use Symfony\Component\HttpFoundation\Response;
class GroupController extends Controller
{
    public function AddGroup (Request $request)
      {  
            if(auth()->user()->id==1)
            {
        $rules=array(
          "group_name"=>"required",
        );
        $validator=Validator::make($request->all() , $rules);
        if($validator->fails()){
          return $validator->errors();
        }
        else
        {
        $group = new Group;
        $group->group_name=$request->group_name;
        $result=$group->save();
        if($result){
          return ["Result"=>"data has been saved"];
      }
      return ["Result"=>"operation failed"];
      }
      }
      
      else
      {
          return ["error"=>"you dont have permission to do this"];
      }
      
      }




      public function indexGroup()
      {
        {
          $groups = Group::all();

          return response()->json($groups);
      }
      }



  // public function indexGroupbyPer()
  // {  

  //   $group_name=Auth::user()->group_name;
  //   return Group::where('group_name','=',$group_name)->get();
   
  // }



  public function addUserToGroup($groupId,$userId)
  {

    if(auth()->user()->id==1)
    {
     
      $group = Group::find($groupId);
      $user = User::find($userId);
      if (!$user || !$group) {
          return response()->json("User or group not found", 404);
      }

     
      if ($user->groups->contains($group)) {
          return response()->json("User is already in the group", 422);
      }

    
      $user->groups()->attach($group);

      return response()->json("User added to the group successfully");
  }

     
        else
        {
            return ["error"=>"you dont have permission to do this"];
        }
        
        }



public function removeUserFromGroup($groupId,$userId)
    {
      if(auth()->user()->id==1)
      {
       
        $user = User::find($userId);
        $group = Group::find($groupId);

        if (!$user || !$group) {
            return response()->json("User or group not found", 404);
        }

        
        if (!$user->groups->contains($group)) {
            return response()->json("User is not in the group", 422);
        }

      
        $user->groups()->detach($group);

        return response()->json("User removed from the group successfully");
    }
  

     
      else
      {
          return ["error"=>"you dont have permission to do this"];
      }
  
  }


  public function destroy($groupId)
  {
    
    if(auth()->user()->id==1)
    {
      $group = Group::find($groupId);

      if (!$group) {
          return response()->json("Group not found", 404);
      }

      
      if ($group->files()->where('status', 'reserved')->exists()) {
          return response()->json("Cannot delete the group. There are reserved files associated with it", 422);
      }
        // Detach all users from the group
        $group->users()->detach();


        // Detach all files from the group
        $group->files()->delete(); 


        // Delete the group
        $group->delete();

      return response()->json("Group deleted successfully");
  
   }
    else
    {
        return ["error"=>"you dont have permission to do this"];
    }
}



public function GroupsFor1User()
{
    $user = auth()->user();

    if (!$user) {
        return response()->json(["error" => "User not authenticated"], 401);
    }

    $myGroups = $user->groups;

    if ($myGroups->isEmpty()) {
        return response()->json(["error" => "User does not have any group"], 401);
    } else {
        return response()->json($myGroups);
    }
}


}




