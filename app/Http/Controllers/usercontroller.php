<?php

namespace App\Http\Controllers;

use App\Models\location_model;
use App\Models\property_special_model;
use App\Models\state_model;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\HasApiTokens;

use Illuminate\Auth\Access\Response as AccessResponse;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\Authenticatable ;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Http\Client\Response as ClientResponse;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Response as FacadesResponse;
use Response;
use Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rules\Unique;
use PhpParser\Node\Stmt\ElseIf_;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Socialite\Facades\Socialite;

class usercontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();

    }


    public function profile_me()
    {
        $user = Auth::User();
        $properties = property_special_model::where('id', optional($user)->id)->first();
        return Response()->json([['user' => $user], ['properties' => $properties]]);


    }
    public function profile_user ($id){
        //way 1
//  $user=DB::select('SELECT * FROM users WHERE id=?',[$id]);

        //way2
        $user=User::find($id);

        return Response()->json(['user'=>$user]);

    }



    public function update()
    {
        $update = User:: find(auth()->user()->id);
        $update->update(Request()->all());

        return Response()->json(['useredit' => $update]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Rigester(Request $request)
    {
        $data = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'age' => 'required',
            'gender' => 'required',
            'information_about' => 'required'

        ]);
        if ($data->fails()) {
            return Response()->json(['error' => $data->errors()]);
        }

//     if($request['image']){
//         if($request->hasFile('image')){

//         $filenameWithExt=$request->file('image')->getClientOriginalName();
//         $filename=pathinfo($filenameWithExt,PATHINFO_FILENAME);
//         $extention=$request->file('image')->getClientOriginalExtension();
//         $filenameToStore=$filename. '-' . time() . '-' .$extention;
//         $path=$request->file('image')->storeAs('image',$filenameToStore);


<<<<<<< HEAD
$user=User::create([
'name'=>$request['name'],
'email'=>$request['email'],
'age'=>$request['age'],
'gender'=>$request['gender'],
'information_about'=>$request['information_about'],
'password' => Hash::make($request['password']),
'phone'=>$request['phone'],










=======
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => $request['password'],
            'age' => $request['age'],
            'gender' => $request['gender'],
            'information_about' => $request['information_about'],
            'password' => Hash::make($request['password']),
            'phone' => $request['phone'],
>>>>>>> cbea51d77dd93b2ea43f19bb8713da481c2b248d
// 'image'=>URL::asset('storage'.$path)
           'image' => $this->upload_image($request)

        ]);

        $token = $user->createToken('authToken')->plainTextToken;
        return Response()->json(['user' => $user, 'token' => $token]);


//     }


//     }

//     $user=User::create([
//         'name'=>$request['name'],
//         'email'=>$request['email'],
//         'password'=>$request['password'],
//         'age'=>$request['age'],
//         'gender'=>$request['gender'],
//         'information_about'=>$request['information_about'],
// 'phone'=>$request['phone'],

//         'password' => Hash::make($request['password'])

//         ]);

//         $token=$user->createToken('authToken')->plainTextToken;
//         return Response()->json(['user'=>$user,'token'=>$token]);


    }
    public function upload_image(Request $request){

        if($request->hasFile("image")){
            $file=$request->file("image");


                $filename=time().rand(1,50).'.'.$file->getClientOriginalExtension();
                $file->move('public/users/',$filename);

                $url=url('public/users/'.$filename);


            return $url;

        }
        else return null;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|alphaNum'


        ]);
        if ($validation->fails()) {

            return Response()->json(['error' => $validation->errors()]);
        }
        $email = $request['email'];
        $password = $request['password'];

        if (!Auth::attempt($request->only('email', 'password'), true)) {

            if (!User::where('email', '=', $email)->first()) {


                return Response()->json(['message' => 'error  email resend right value', 'token' => null]);

            }
            if (!User::where('password', '=', $password)->first()) {
                return Response()->json(['message' => 'error password resend right value', 'token' => null]);


            } else
                return Response()->json(['message' => 'error value resend right value', 'token' => null]);

        }

        $user = User::where('email', $request['email'])->first();
        $token = $user->createToken('authToken')->plainTextToken;


        return Response()->json(['user' => $user, 'token' => $token]);

    }

    public function logout(Request $request)
    {


//     $token = auth()->user()->tokens;


//  //   $token->delete();
//  $token->destroy();
        $accessToken = $request->bearerToken();

// Get access token from database
        $token = PersonalAccessToken::findToken($accessToken);

// Revoke token
<<<<<<< HEAD
$token->delete();
return Response()->json(['massage' => 'logged out successfully  ']);
=======
        $token->delete();
        return Response()->json(['massage' => 'logged out successfully  ']);
>>>>>>> cbea51d77dd93b2ea43f19bb8713da481c2b248d

    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */


    public function public_search(Request $request)
    {

        $name = $request['name'];
        $users = User::where('name', 'like', '%' . $name . '%')->get();
        if (!$users->isEmpty()) {
            foreach ($users as $user) {

                $id = $user->id;
                $nameuser = $user->name;
                $property = property_special_model::where('users_id', '=', $id)->get();
                if (!$property->isEmpty()) {

                    foreach ($property as $pro) {
                        $locationId = $pro->location_id;
                        $stateId = location_model::find($locationId)->state_id;
                        $state = state_model::find($stateId)->nameState;
                        $location = location_model::find($locationId)->address;

                        $h[] = array(
                            "id" => $id,
                            "name user" => $nameuser,
                            "image" => $user->image,
                            "location property" => $location,
                            "state" => $state,
                            "hello"


                        );

                    }
                } else {
                    $h[] = array("name user" => $nameuser,
                        "id" => $id,
                        "image" => $user->image,
                        "location property" => null,
                        "state" => null,
                        "welcom"

                    );

                }


            }


        } else {
            $property1 = property_special_model::where('typeofproperty', 'like', '%' . $name . '%')->get();

            if (!$property1->isEmpty()) {
                foreach ($property1 as $pro) {

                    $locationId = $pro->location_id;
                    $stateId = location_model::find($locationId)->state_id;
                    $state = state_model::find($stateId)->nameState;
                    $location = location_model::find($locationId)->address;
                    $iduser = $pro->users_id;
                    $nameuser = User::find($iduser)->name;

                    $h[] = array(
                        "id property" => $pro->id,
                        "name user" => $nameuser,
                        "type property" => $pro->typeofproperty,
                        "location property" => $location,
                        "state" => $state,
                        "hhhhh"

                    );
                }


            } else {
                $property2 = property_special_model::where('rent_or_sell', 'like', '%' . $name . '%')->get();

                if (!$property2->isEmpty()) {
                    foreach ($property2 as $pro) {

                        $locationId = $pro->location_id;
                        $stateId = location_model::find($locationId)->state_id;
                        $state = state_model::find($stateId)->nameState;
                        $location = location_model::find($locationId)->address;
                        $iduser = $pro->users_id;
                        $nameuser = User::find($iduser)->name;

                        $h[] = array(
                            "id property" => $pro->id,
                            "name user" => $nameuser,
                            "type property" => $pro->typeofproperty,
                            "type offer" => $pro->rent_or_sell,
                            "location property" => $location,
                            "state" => $state,
                            "ddddd"

                        );
                    }


                } else return Response()->json(['  no  result ']);


            }


        }

        return Response()->json(['result' => $h]);


    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
<<<<<<< HEAD

    public function upload_image(Request $request){
        $images=array();
        if($request['image']){
      
            $files=$request->file('image');
       
                   foreach($files  as  $image){
                        $filename=$image->getClientOriginalName();
                        $filenameExtention=$image->getClientOriginalExtension();
                        $filename=pathinfo($filename,PATHINFO_FILENAME);
                        $filenameWithExt= $filename .'-' . time() .'.' . $filenameExtention;
                        $path=$image->storeAs('image',$filenameWithExt,'public');
                        $url=URL::asset($path);
                       

                      array_push($images,$url);
          
            }
             return $images;
        
        }  
        else return null;          
    }

    public function upload_video(Request $request){


    //     $this->validate($request, [
    //         'video' => 'required|file|mimetypes:video/mp4'

    //   ]);
      
      $video=$request->file('video');

      if ($request['video']){
        $filename=$video->getClientOriginalName();
        $filenameExtention=$video->getClientOriginalExtension();
        $filename=pathinfo($filename,PATHINFO_FILENAME);
        $filenameWithExt= $filename .'-' . time() .'.' . $filenameExtention;
        $path=$video->storeAs('video',$filenameWithExt,'public');
        $url=URL::asset($path);

      
      
      return $url;
      }
      else return null;
    }

public function redirect_google(){

    return Socialite::driver('google')->redirect();

}
public function handleCallback(){

try{
$user=Socialite::driver('google')->user();
$finduser=User::where('google_id',$user->id)->first();

if($finduser){

Auth::login($finduser);
return  Response()->json($finduser);

}
else{
    $newuser=User::create([
        'name'=>$user->name,
        'email'=>$user->email,
        'google_id'=>$user->google_id,
        'age'=>$user->age,
        'gender'=>$user->gender,
        'information_about'=>$user->information_about,
        'password' => Hash::make('my-google'),
        'phone'=>$user->phone
        
    ]);
    Auth::login($newuser);
    return response()->json($newuser);
}


}
catch(Exception $e){
    dd($e->getMessage());
}

}


=======
>>>>>>> cbea51d77dd93b2ea43f19bb8713da481c2b248d
}

