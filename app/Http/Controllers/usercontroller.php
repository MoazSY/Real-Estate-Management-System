<?php
namespace App\Http\Controllers;

use App\Models\location_model;
use App\Models\property_special_model;
use App\Models\state_model;
use App\Models\favorate_model;
use App\Models\rate_property_model;
use App\Models\Bank_model;
use App\Models\Account_bank;
use App\Models\passwordReset;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\ResetPassword as PasswordResetNotification;
use App\Mail\PasswordResetVerification;
use App\Mail\VerificationEmail;
use Illuminate\Support\Facades\Password;
use App\Models\ResetCodePassword;
use App\Mail\SendCodeResetPassword;
use Illuminate\Support\Facades\Mail;
use App\Mail\CodeMail;

use Illuminate\Http\Request;
use App\Models\User;
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
use Illuminate\Support\Str;

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
public function delete($id){
    $user=User::find($id)->delete();
    return Response()->json([User::all()]);
}

    public function profile ($id){
        //way 1
//  $user=DB::select('SELECT * FROM users WHERE id=?',[$id]);

 //way2
 $user=User::find($id);
 $user_id=$user->id;
 $property=property_special_model::where('users_id', '=' , $id)->get();

if(!$property->isEmpty()){
    foreach($property as $pro){

        $locationid=$pro->location_id;
        $location=location_model::find($locationid);
        $stateid=$location->state_id;
        $state=state_model::find($stateid);

$h[]=array(
"property"=>$pro,
"location"=>$location,
"state"=>$state

);

    }
 return Response()->json(['user'=>$user,'user property'=>$h]);

}
$h=null;
 return Response()->json(['user'=>$user,'user property'=>$h]);


    }


 public function profile_me(){

    $userId=auth()->user()->id;
    $user=User::find($userId);

    $property=property_special_model::where('users_id', '=' , $userId)->get();

if(!$property->isEmpty()){
    foreach($property as $pro){

        $locationid=$pro->location_id;
        $location=location_model::find($locationid);
        $stateid=$location->state_id;
        $state=state_model::find($stateid);
        $rateSum=rate_property_model::where('users_id','=',$userId)->sum('rate');
        $countRate=rate_property_model::where('users_id','=',$userId)->count();
     if($countRate==0){
        $rate=0.0;
     } else
    $rate = floatval($rateSum) / floatval($countRate);

$h[]=array(
"property"=>$pro,
"location"=>$location,
"state"=>$state,
"myRate" => sprintf("%.1f", $rate),

);

    }

 return Response()->json(['user'=>$user,'user property'=>$h]);

}
$h=null;
 return Response()->json(['user'=>$user,'user property'=>$h]);


 }
public function update( Request $request ){
$update= User:: find(auth()->user()->id);

 $update->update(Request()->all());

 if($request->hasFile('image')){

$update->image=$this->upload_image($request);
$update->save();
 }
 else{
    $update->update(Request()->all());
    $update->save();
 }
 return Response()->json(['useredit'=>$update]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Rigester(Request $request)
    {
    $data= Validator::make($request->all(),[
        'name' =>'required',
        'phone'=>'required|unique:users',
        'email'=>'required|email|unique:users',
        'password' =>'required',
        'age'=>'required',
        'gender'=>'required',
        'information_about'=>'required'

    ]);
    if ($data->fails()) {
        return Response()->json($data->errors());
    }

$user=User::create([
'name'=>$request['name'],
'email'=>$request['email'],
'age'=>$request['age'],
'gender'=>$request['gender'],
'information_about'=>$request['information_about'],
'password' => Hash::make($request['password']),
'phone'=>$request['phone'],

 'image'=> $this->upload_image($request)

]);

$token=$user->createToken('authToken')->plainTextToken;
return Response()->json(['user'=>$user,'token'=>$token]);

     }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validation=Validator::make($request->all(),[
       'email'=>'required|email',
       'password'=>'required|alphaNum'


        ]);
        if($validation->fails()){

            return Response()->json(['error'=>$validation->errors()]);
        }
        $email=$request['email'];
        $password=$request['password'];

if(!Auth::attempt($request->only('email','password'),true)){

    if( !User::where('email','=',$email)->first()){


    return Response()->json(['message'=>'error  email resend right value','token'=>null]);

    }
    if(!User::where('password','=',$password)->first()){
        return Response()->json(['message'=>'error password resend right value','token'=>null]);

    }
else
    return Response()->json(['message'=>'error value resend right value','token'=>null]);

}
$user=User::where('email',$request['email'])->first();
$token=$user->createToken('authToken')->plainTextToken;
return Response()->json(['user'=>$user,'token'=>$token]);
    }

public function logout(Request $request){


//     $token = auth()->user()->tokens;


//  //   $token->delete();
//  $token->destroy();
$accessToken = $request->bearerToken();

// Get access token from database
$token = PersonalAccessToken::findToken($accessToken);

// Revoke token
$token->delete();
return Response()->json(['massage' => 'logged out successfully  ']);

}


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function public_search(Request $request){

        $name=$request['name'];
        $users=User::where('name','like','%'. $name.'%')->get();
       if(!$users->isEmpty()){
        foreach($users as $user){

            $id=$user->id;

            $rateSum=rate_property_model::where('users_id','=',$id)->sum('rate');
            $countRate=rate_property_model::where('users_id','=',$id)->count();
            if($countRate==0){
            $rate=0.0;
            } else
            $rate = floatval($rateSum) / floatval($countRate);


            $nameuser=$user->name;

            $property=property_special_model::where('users_id','=',$id)->get();
                if(!$property->isEmpty()){

                    foreach($property as $pro){
                    if($pro->wasSell_or_wasRented==null){

                        $locationId=$pro->location_id;
                        $stateId=location_model::find($locationId)->state_id;
                        $state=state_model::find($stateId)->nameState;
                        $location=location_model::find($locationId)->address;


                        $h[]=array(
                            'owner id'=>$user->id,
                            'owner phone'=>$user->phone,
                            "owner image"=>$user->image,
                            'rate'=>sprintf("%.1f", $rate),
                            "id property"=>$pro->id,
                            "owner name"=>$user->name,
                            "his property"=>$pro,
                            "type property"=>$pro->typeofproperty,
                            "type offer"=>$pro->rent_or_sell,
                            "location property"=>$location,
                            "state"=>$state,
                            "ddddd"



                        );
                    }
                    else{
                        continue;
                    }


                    }

                }
                else{
                    $h[]=array(
                        'owner id'=>$user->id,
                        'owner phone'=>$user->phone,
                        "owner image"=>$user->image,
                        'rate'=>sprintf("%.1f", $rate),
                        "owner name"=>$user->name,
                        "ddddd"
                );

                }



       }



        }
        else{
            $property1=property_special_model::where('typeofproperty','like','%'. $name.'%')->get();

            if(!$property1->isEmpty()){
                foreach($property1 as $pro){
                 if($pro->wasSell_or_wasRented==null){

                $locationId=$pro->location_id;
                $stateId=location_model::find($locationId)->state_id;
                $state=state_model::find($stateId)->nameState;
                $location=location_model::find($locationId)->address;
                $iduser=$pro->users_id;
                $user=User::find($iduser);
                $rateSum=rate_property_model::where('users_id','=',$iduser)->sum('rate');
                $countRate=rate_property_model::where('users_id','=',$iduser)->count();
                if($countRate==0){
                $rate=0.0;
                } else
                $rate = floatval($rateSum) / floatval($countRate);


                $nameuser=User::find($iduser)->name;

                $h[]=array(
                    'owner id'=>$user->id,
                        'owner phone'=>$user->phone,
                        "owner image"=>$user->image,
                        "id property"=>$pro->id,
                        'rate'=>sprintf("%.1f", $rate),
                        "owner name"=>$user->name,
                        "his property"=>$pro,
                        "type property"=>$pro->typeofproperty,
                        "type offer"=>$pro->rent_or_sell,
                        "location property"=>$location,
                        "state"=>$state,
                        "ddddd"

                );
                    }
                    else{
                        continue;

                    }




                }


            }
            else {
                $property2=property_special_model::where('rent_or_sell','like','%'. $name.'%')->get();

                if(!$property2->isEmpty()){
                    foreach($property2 as $pro){
                     if($pro->wasSell_or_wasRented==null){
                        $locationId=$pro->location_id;
                        $stateId=location_model::find($locationId)->state_id;
                        $state=state_model::find($stateId)->nameState;
                        $location=location_model::find($locationId)->address;
                        $iduser=$pro->users_id;
                        $user=User::find($iduser);
                        $rateSum=rate_property_model::where('users_id','=',$iduser)->sum('rate');
                        $countRate=rate_property_model::where('users_id','=',$iduser)->count();
                        if($countRate==0){
                        $rate=0.0;
                        } else
                $rate = floatval($rateSum) / floatval($countRate);


                        $nameuser=User::find($iduser)->name;

                        $h[]=array(
                            'owner id'=>$user->id,
                            'owner phone'=>$user->phone,
                            "owner image"=>$user->image,
                            "id property"=>$pro->id,
                            'rate'=>sprintf("%.1f", $rate),
                            "owner name"=>$user->name,
                            "his property"=>$pro,
                            "type property"=>$pro->typeofproperty,
                            "type offer"=>$pro->rent_or_sell,
                            "location property"=>$location,
                            "state"=>$state,
                            "ddddd"
                        );
                     }
                     else{
                        continue;
                     }


                    }


                }
                if( empty($h) ){
                    return response()->json(['result'=>null]);
                }

                // else return Response()->json(['no  result ']);


            }


        }

        return Response()->json(['result'=>$h]);



    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function upload_image(Request $request){
        $images=array();
        if($request['image']){
            $files=$request->file('image');
                   foreach($files  as  $image){
                        // $filename=$image->getClientOriginalName();
                        $filenameExtention= uniqid() . '.' . $image->getClientOriginalExtension();
                        $image->move('public/Image/',$filenameExtention);
                        $url=url('public/Image/',$filenameExtention);
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
        $filenameExtention= time(). '.' .$video->getClientOriginalExtension();
        $video->move('public/video/',$filenameExtention);
        $url=url('public/video/',$filenameExtention);

      return $url;
      }
      else return null;
    }

public function redirect_google(){

    return Socialite::driver('google')->redirect();

}
public function handleCallback(){

// try{

$user=Socialite::driver('google')->user();
$finduser=User::where('google_id','=',$user->id)->first();

if($finduser==true){

Auth::login($finduser);

$token=$finduser->createToken('authToken')->plainTextToken;
$refreshToken=$finduser->refreshToken;
return  Response()->json(['user login'=>$finduser,'token'=>$token,'refreshToken'=>$refreshToken]);

}

else{
    $newuser=User::create([
        'name'=>$user->name,
        'email'=>$user->email,
        'google_id'=>$user->id,
        'age'=>$user->age,
        'gender'=>$user->gender,
        'information_about'=>$user->information_about,
        'password' => Hash::make('my-google'),
        'phone'=>$user->phone

    ]);
    Auth::login($newuser);
    $token=$newuser->createToken('authToken')->plainTextToken;
$refreshToken=$newuser->refreshToken;
return  Response()->json(['user register'=>$newuser,'token'=>$token,'refreshToken'=>$refreshToken]);

}


// }
// catch(Exception  $e){
    // dd($e->getMessage());
// }

}
public function addToFavorate($id){
    $userid=auth()->user()->id;
    $user=User::find($userid)->first();

    if( !$user->isEmpty){
    $username=$user->name;
    $userImage=$user->image;
    $property=property_special_model::find($id);
    $propertyimage=$property->image;
    $propertyOwnerID=$property->users_id;
    $rateSum=rate_property_model::where('users_id','=',$propertyOwnerID)->sum('rate');
    $countRate=rate_property_model::where('users_id','=',$propertyOwnerID)->count();
    if($countRate==0){
        $rate=0;
        $propertyOwnerName=$user=User::find($propertyOwnerID)->name;
        $propertyOwnerImage=$user=User::find($propertyOwnerID)->image;

            $favorate=favorate_model::create(['users_id'=>$userid,'property_special_id'=>$id]);

    return response()->json(['favorate'=>$favorate,'username'=>$username
    ,'user Image'=>$userImage,
    'owner name'=>$propertyOwnerName,'owner image'=> $propertyOwnerImage,'rate'=>$rate]);
    }
    $rate=$rateSum/$countRate;
    $propertyOwnerName=$user=User::find($propertyOwnerID)->name;
    $propertyOwnerImage=$user=User::find($propertyOwnerID)->image;

        $favorate=favorate_model::create(['users_id'=>$userid,'property_special_id'=>$id]);

return response()->json(['favorate'=>$favorate,'username'=>$username
,'user Image'=>$userImage,
'owner name'=>$propertyOwnerName,'owner image'=> $propertyOwnerImage,'rate'=>$rate]);
    }
    else return response()->json([null]);

}
public function show_favorate(Request $request){
$userid=auth()->user()->id;
$username=User::find($userid)->name;

$favorate=favorate_model::where('users_id','=',$userid)->get();
if(!$favorate->isEmpty()){
    foreach($favorate as $f){

        $property_id=$f->property_special_id;
        $property=property_special_model::where('id','=',$property_id)->first();
        if($property){
            $locationId=$property->location_id;
            $stateId=location_model::find($locationId)->state_id;
            $state=state_model::find($stateId)->nameState;
            $location=location_model::find($locationId)->address;
            $iduser=$property->users_id;
            $rateSum=rate_property_model::where('users_id','=',$iduser)->sum('rate');
            $countRate=rate_property_model::where('users_id','=',$iduser)->count();
            if($countRate==0){
                $rate=0.0;
            }
            else
            $rate = floatval($rateSum) / floatval($countRate);
            $owner = User::find($iduser);
            $nameuser=User::find($iduser)->name;

            $h[]=array(
            "owner name"=>$nameuser,
            'owner id'=>$userid,
            'owner phone'=>$owner->phone,
            "owner image"=>$owner->image,
            "rate"=>sprintf("%.1f", $rate),
            "location property"=>$location,
            "property"=>$property,
            "state"=>$state,
            );
        }
        else{
            continue;
        }


}
if( empty($h) ){
    return response()->json(null);}
    else
return response()->json(['result'=> $h]);
}
return response()->json(['result'=>null]);

}
public function delete_favorate(Request $request){
    $userid=auth()->user()->id;
    $idproperty=$request['id_property'];
    $favorate=favorate_model::where('property_special_id','=',$idproperty)->where('users_id','=',$userid)->first();
    $favorate->delete();

    return response()->json(['delete favorate successfully',$favorate]);

}


public function addRate(Request $request){
$id=$request['id_owner'];
$rateValue=$request['rateValue'];


$validate=Validator::make( $request->all(),[
    'id_owner'=>'required',
    'rateValue'=>'required|integer|min:1|max:5'

]);
if($validate->fails()){

    return response()->json($validate->errors());
}

    $userId=auth()->user()->id;
    $user=User::find($userId)->first();
    if( !$user->isEmpty){
        $username=$user->name;
        $userImage=$user->image;
        $owner=User::find($id)->name;

        $rate=rate_property_model::create([
            'users_id'=>$id,
            'userUseRate'=>$userId,
            'rate'=>$rateValue

        ]);
        return response()->json(['rate'=>$rate,'user who use rate'=>$username,'owner who is rated'=>$owner]);
    }
    else return response()->json(null);
}


public function filters(Request $request)
{
    $validation = Validator::make($request->all(), [

        'typeofproperty' => 'required',
        'rent_or_sell' => 'required',


    ]);
    if ($validation->fails()) {


        return Response()->json(['error' => $validation->errors()]);

    }

    $query = property_special_model::query();

    $query->where('rent_or_sell', $request->input('rent_or_sell'));

    $query->where('typeofproperty', $request->input('typeofproperty'));

    if ($request->has('state')) {
        $query->whereHas('location.state', function ($query) use ($request) {
            $query->where('namestate', $request->input('state'));
        });
    }


    if ($request->has('location')) {
        $query->whereHas('location', function ($query) use ($request) {
            $query->where('address', $request->input('location'));
        });
    }


    if ($request->has('minarea')) {
        $min_area = $request->input('minarea');
        $max_area = $request->input('maxarea');
        $query->whereBetween('area', [$min_area, $max_area]);
    }

    if ($request->has('num_of_rooms')) {

        $minRoom=$request->num_of_rooms -1;
        $maxRoom=$request->num_of_rooms +1;
        $query->whereBetween('numberofRooms', [$minRoom,$maxRoom]);

    }

    if ($request->has('minprice')) {
        $minprice=$request->input('minprice');
        $maxprice=$request->input('maxprice');

        $query->whereBetween('price', [$minprice,$maxprice]);
    }

    if ($request->has('monthlyRent')) {
        $min_monthly=$request->input('minRent');
        $max_monthly=$request->input('maxRent');
        $query->whereBetween('monthlyRent', [$min_monthly,$max_monthly]);
    }

    if ($request->has('bathRoom')) {
        $minRoom=$request->bathRoom -1;
        $maxRoom=$request->bathRoom +1;
        $query->whereBetween('bathRoom', [$minRoom,$maxRoom]);

    }


    $properties = $query->orderBy('price', 'asc')->get();

    $properties = $query->orderBy('monthlyRent', 'asc')->get();


    $props=array();
    foreach ($properties as $property)
    {
    if($property->wasSell_or_wasRented==null){

        $location_id=$property->location_id;
        $location=location_model::find($location_id);
        $state_id=$location->state_id;
        $state=state_model::find($state_id);
        $owner=User::find($property->users_id);
        $id=$owner->id;
        $rateSum=rate_property_model::where('users_id','=',$id)->sum('rate');
        $countRate=rate_property_model::where('users_id','=',$id)->count();
        if($countRate==0){
            $rate=0.0;
        }
        else
        $rate = floatval($rateSum) / floatval($countRate);


        $nameOwner=$owner->name;
        $imageOwner=$owner->image;
        array_push($props,[
            'owner name'=>$nameOwner,
            'owner image'=>$imageOwner,
            'owner phone' => $owner->phone,
            'owner id' => $id,
            'rate' => sprintf("%.1f", $rate),
            'property'=>$property,
            'location'=>$location,
            'state'=>$state,
        ]);
    }
    else{
        // $h[]=null;
        continue;

    }
}
    if( empty($props) ){
        return response()->json(null);
    }

    return Response()->json(['properties' => $props]);

}


}

