<?php

namespace App\Http\Controllers;

use App\Models\location_model;
use App\Models\property_special_model;
use App\Models\state_model;
use App\Models\favorate_model;
use App\Models\rate_property_model;
use App\Models\Bank_model;
use App\Models\Account_bank;
use App\Models\Admin_model;
use App\Models\inform_model;
use App\Models\selles_model;
use App\Models\rents_model;
use Carbon\Carbon;
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

class adminController extends Controller{

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

$admin=Admin_model::create([
'name'=>$request['name'],
'email'=>$request['email'],
'age'=>$request['age'],
'gender'=>$request['gender'],
'information_about'=>$request['information_about'],
'password' => Hash::make($request['password']),
'phone'=>$request['phone'],
 'image'=> $this->upload_image($request)
]);

$token=$admin->createToken('authToken')->plainTextToken;
return Response()->json(['admin'=>$admin,'token'=>$token]);

     }

//      public function login(Request $request)
//      {
//          $validation=Validator::make($request->all(),[
//         'email'=>'required|email',
//         'password'=>'required|alphaNum'


//          ]);
//          if($validation->fails()){

//              return Response()->json(['error'=>$validation->errors()]);
//          }
//          $email=$request['email'];
//          $password=$request['password'];

//  if(!Auth::guard('Admin')->attempt($request->only('email','password'),true)){

//      if( !Admin_model::where('email','=',$email)->first()){


//      return Response()->json(['message'=>'error  email resend right value','token'=>null]);

//      }
//      if(!Admin_model::where('password','=',$password)->first()){
//          return Response()->json(['message'=>'error password resend right value','token'=>null]);


//      }
//  else
//      return Response()->json(['message'=>'error value resend right value','token'=>null]);

//  }
//  $admin=Admin_model::where('email',$request['email'])->first();
//  $token=$admin->createToken('authToken')->plainTextToken;
//  return Response()->json(['admin'=>$admin,'token'=>$token]);
//      }

     public function logout_admin(Request $request){
        $accessToken = $request->bearerToken();

        // Get access token from database
        $token = PersonalAccessToken::findToken($accessToken);

        // Revoke token
        $token->delete();
        return Response()->json(['massage' => 'logged out successfully  ']);

        }

     public function inform(Request $request){
        $type_of_informing=$request['type_informing'];
        $iduser=auth()->user()->id;
        if($request['user_who_isinformed_about_Him']){

            $inform=inform_model::create([
                'users_id'=>$iduser,
                'admin_id'=>$request['admin_id'],
                'property_special_id'=>null,
                'user_who_isinformed_about_Him'=>$request['user_who_isinformed_about_Him'],
                'type_of_informing'=>$request['type_of_informing']
            ]);
            return response()->json(["inform"=>$inform]);
        }

        if($request['property_special_id']){

            $inform=inform_model::create([
                'users_id'=>$iduser,
                'admin_id'=>$request['admin_id'],
                'property_special_id'=>$request['property_special_id'],
                'user_who_isinformed_about_Him'=>null,
                'type_of_informing'=>$request['type_of_informing']
            ]);
            return response()->json(["inform"=>$inform]);

        }

     }








    // public function upload_image(Request $request){
    //     $images=array();
    //     if($request['image']){

    //         $files=$request->file('image');

    //                foreach($files  as  $image){
    //                     // $filename=$image->getClientOriginalName();
    //                     $filenameExtention= uniqid() . '.' . $image->getClientOriginalExtension();
    //                     $image->move('public/Image/',$filenameExtention);
    //                     $url=url('public/Image/',$filenameExtention);

    //                   array_push($images,$url);
    //         }
    //          return $images;
    //     }
    //     else return null;
    // }


    public function suspend1(Request $request)
    {
        $id=$request['id'];
        $duration=$request['duration'];
        $user = User::findOrFail($id);

        // Set the suspension details
        $user->suspended_at = Carbon::now();
        $user->suspension_duration = $duration;
        $user->save();

        // Handle any additional suspension actions (e.g., logging out the user)

        return response()->json(['user suspend  successfully']);
    }

    public function unsuspend1(Request $request)
    {
        $id=$request['id'];
        $user = User::findOrFail($id);

        // Remove the suspension details
        $user->suspended_at = null;
        $user->suspension_duration = null;
        $user->save();

        // Handle any additional unsuspension actions

        return response()->json(['user unsuspend  successfully']);

    }
    //----------------------------------------------------------------------
    //web
    public function delete_property($id)
    {
        $property=property_special_model::find($id);
        $property->delete();

//            return response()->json('property deleted');
        return redirect()->route('Admindashboard');
    }



    public function getproperty( $id){

        $property=property_special_model::find($id);

        if($property){
            $idlocation=$property->location_id;
            $userid=$property->users_id;
            $rateSum=rate_property_model::where('users_id','=',$userid)->sum('rate');
            $countRate=rate_property_model::where('users_id','=',$userid)->count();
            if($countRate==0){
                $rate=0;

                $user=User::find($userid);
                $nameuser=$user->name;
                $userimage=$user->image;
                $location=location_model::find($idlocation);
                $name=$location->address;
                $stateid=$location->state_id;
                $state=state_model::find($stateid);
                $namestate=$state->nameState;

//                return Response()->json(['owner name'=>$nameuser,'owner images'=>$userimage,'rate'=>$rate,'locationName'=>$name,'namestate'=>$namestate,'property'=> $property]);
                return view('Admin.propertydetails', ['details' => [$property,$nameuser,$rate,$name,$namestate,$userimage]]);

            }
            $rate=$rateSum/$countRate;
            $user=User::find($userid);
            $nameuser=$user->name;
            $userimage=$user->image;
            $location=location_model::find($idlocation);
            $name=$location->address;
            $stateid=$location->state_id;
            $state=state_model::find($stateid);
            $namestate=$state->nameState;

            return view('Admin.propertydetails', ['details' => [$property,$nameuser,$rate,$name,$namestate,$userimage]]);

//            return Response()->json(['owner name'=>$nameuser,'owner images'=>$userimage,'rate'=>$rate,'locationName'=>$name,'namestate'=>$namestate,'property'=> $property]);
        }
        else return view('Admin.propertydetails',['data' => []]);


    }
    public function property(){
        $property=property_special_model::inRandomOrder()->get();
        $h = [];
        if(!$property->isEmpty()){
            foreach($property as $pro){
                $userid=$pro->users_id;
                $rateSum=rate_property_model::where('users_id','=',$userid)->sum('rate');
                $countRate=rate_property_model::where('users_id','=',$userid)->count();
                if($countRate==0){
                    $rate=0;
                } else
                    $rate=$rateSum/$countRate;
                $user=User::find($userid);
                $nameuser=$user->name;
                $userimage=$user->image;
                $locationid=$pro->location_id;
                $location=location_model::find($locationid);
                $stateid=$location->state_id;
                $state=state_model::find($stateid);

                $h[]=array(
                    "owner name"=>$nameuser,
                    "owner image"=>$userimage,
                    "rate"=>$rate,
                    "property"=>$pro,
                    "location"=>$location,
                    "state"=>$state

                );

            }
            return response()->json(['data' => $h]);

//return Response()->json($h);
//    return view('properties')->with('h', $h);
        }
        else {
            return response()->json(['data' => []]);
        }
//else return null;

    }

    public function sells_counter(Request $request)
    {
        $sellsCounter=selles_model::get()->count();
        return response()->json($sellsCounter);
//        return view('counter', [
//            'sellsCounter' => $sellsCounter,
//        ]);
    }


    public function rents_counter(Request $request)
    {
        $rentsCounter=rents_model::get()->count();
        return response()->json($rentsCounter);
//        return view('counter', [
//            'rentsCounter' => $rentsCounter,
//        ]);
    }
    public function sells(Request $request)
    {
        $s=[];
        $sells=selles_model::get();

        foreach ($sells as $sell) {
            $selling_number=$sell->id;
            $seller_id=$sell->users_id;
            $seller=User::find($seller_id);
            $buyer_id=$sell->id_buyer;
            $buyer=User::find($buyer_id);
            $property_id=$sell->property_special_id;
            $property=property_special_model::find($property_id);
            $s[]=array(
                "selling number"=>$selling_number,
                "seller"=>$seller,
                "buyer"=>$buyer,
                "property"=>$property
            );
        }
        return response()->json(['sells'=>$s]);
//        return view('counter', [
//            'sellsCounter' => $sellsCounter,
//        ]);
    }


    public function rents(Request $request)
    {$r=[];
        $rents=rents_model::get();
        foreach ($rents as $rent) {
            $renting_number=$rent->id;
            $owner_id=$rent->owner_id;
            $owner=User::find($owner_id);
            $renter_id=$rent->renter_id;
            $renter=User::find($renter_id);
            $property_id=$rent->property_special_id;
            $property=property_special_model::find($property_id);
            $period=$rent->period;
            $rent_start=$rent->rent_start;
            $rent_end=$rent->rent_end;
            $r[]=array(
                "renting number"=>$renting_number,
                "owner"=>$owner,
                "renter"=>$renter,
                "property"=>$property,
                "period"=>$period,
                "rent_start"=>$rent_start,
                "rent_end"=>$rent_end
            );
        }
        return response()->json(['rents'=>$r]);
//        return view('counter', [
//            'rentsCounter' => $rentsCounter,
//        ]);
    }
    public function getuser( $id){

        $user=User::find($id);

        if($user){
            $rateSum=rate_property_model::where('users_id','=',$id)->sum('rate');
            $countRate=rate_property_model::where('users_id','=',$id)->count();
            if($countRate==0){
                $rate=0;

                $nameuser=$user->name;
                $userimage=$user->image;
                $userphone=$user->phone;
                $useremail=$user->email;
                $userage=$user->age;
                $usergender=$user->gender;
                $userinfo=$user->information_about;
                $suspended=$user->suspended_at;

//                return Response()->json(['owner name'=>$nameuser,'owner images'=>$userimage,'rate'=>$rate,'locationName'=>$name,'namestate'=>$namestate,'property'=> $property]);
                return view('Admin.userdetails', ['details' => [$user,$nameuser,$rate,$userimage,$userphone,$useremail,$userage,$usergender,$userinfo,$suspended]]);

            }
            $rate=$rateSum/$countRate;
            $nameuser=$user->name;
            $userimage=$user->image;
            $userphone=$user->phone;
            $useremail=$user->email;
            $userage=$user->age;
            $usergender=$user->gender;
            $userinfo=$user->information_about;

            return view('Admin.userdetails', ['details' => [$user,$nameuser,$rate,$userimage,$userphone,$useremail,$userage,$usergender,$userinfo]]);

//            return Response()->json(['owner name'=>$nameuser,'owner images'=>$userimage,'rate'=>$rate,'locationName'=>$name,'namestate'=>$namestate,'property'=> $property]);
        }
        else return view('Admin.userdetails',['details' => []]);


    }
    public function getreports(Request $request)
    {
        $reports=inform_model::get();

        $r=[];
        foreach ($reports as $report){

            $property=property_special_model::find($report->property_special_id);
            if($property){
                $owner=User::find($property->users_id);

            }

            $user=User::find($report->user_who_isinformed_about_Him);
            $reporter=User::find($report->users_id);
            $reason=$report->type_of_informing;
            $r[]=array(
                "property"=>$property,
                "owner"=>$owner,
                "user"=>$user,
                "reporter"=>$reporter,
                "reason"=>$reason,
            );
        }
        return response()->json(['reports'=>$r]);

    }
    public function getcomplaints(Request $request)
    {
        $complaints=Complain::get();

    $c=[];
        foreach ($complaints as $complaint){

            $user=User::find($complaint->user_id);
            $complain=$complaint->complain;
            $c[]=array(
                "user"=>$user,
                "complain"=>$complain
            );
        }
        return response()->json(['complaints'=>$c]);

    }
//    public function login(Request $request)
//    {
//        $validation=Validator::make($request->all(),[
//            'email'=>'required|email',
//            'password'=>'required|alphaNum'
//
//
//        ]);
////        if($validation->fails()){
////
////            return Response()->json(['success'=>false,'message'=>$validation->errors()]);
////        }
//        if ($validation->fails()) {
//            $errors = $validation->errors();
//            $errorMessages = [];
//
//            foreach ($errors->all() as $message) {
//                $errorMessages[] = $message;
//            }
//
//            return response()->json(['success'=>false,'message' => $errorMessages]);
//        }
//        $email=$request['email'];
//        $password=$request['password'];
//
//        if(!Auth::attempt($request->only('email','password'),true)){
//
//            if( !User::where('email','=',$email)->first()){
//
//
//                return Response()->json(['success'=>false,'message'=>'error  email resend right value','token'=>null]);
//
//            }
//            if(!User::where('password','=',$password)->first()){
//                return Response()->json(['success'=>false,'message'=>'error password resend right value','token'=>null]);
//
//
//            }
//            else
//                return Response()->json(['success'=>false,'message'=>'error value resend right value','token'=>null]);
//
//        }
//
//        $user=User::where('email',$request['email'])->first();
//        $token=$user->createToken('authToken')->plainTextToken;
//
//
//        return Response()->json(['success'=>true,'token'=>$token]);
//
//    }


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
//dd($credentials);

        if (Auth::guard('admin')->attempt($credentials)) {
//            dd(10);
            // Authentication passed
//            session()->put('token',$request->user()->createToken('web')->plainTextToken);
            return redirect()->route('Admindashboard');
//            return redirect()->route('Admindashboard')->with('token', $request->user()->createToken('web')->plainTextToken);
        } else {
            // Authentication failed
            $user = Admin_model::where('email', $request->email)->first();
//dd($user);
            if (!$user) {
                session()->put('error', 'Invalid email');
                return redirect()->back();
//                return back()->with('error', 'Invalid email');
            } else {
                session()->put('error', 'Invalid password');
                return redirect()->back();
//                return back()->with('error', 'Invalid password');
            }

        }
    }



//    public function loginb(Request $request)
//    {
//        $credentials = $request->only('email', 'password');
//
//        if (Auth::attempt($credentials)) {
//            session()->put('token',$request->user()->createToken('web')->plainTextToken);
//            return redirect()->route('Bankdashboard');
////            return redirect()->route('Admindashboard')->with('token', $request->user()->createToken('web')->plainTextToken);
//        } else {
//            $user = User::where('email', $request->email)->first();
//
//            if (!$user) {
//                session()->put('error', 'Invalid email');
//                return redirect()->back();
////                return back()->with('error', 'Invalid email');
//            } else {
//                session()->put('error', 'Invalid password');
//                return redirect()->back();
////                return back()->with('error', 'Invalid password');
//            }
//
//        }
//    }
    public function logout(Request $request)
    {

        Auth::guard('admin')->logout();
        return redirect('Admin');
    }

    public function addadmin(Request $request)
    {
//
//        $name = $request->input('name');
//        $email = $request->input('email');
//        $password = $request->input('password');
//        $phone = $request->input('phone');
//        $image = $request->input('image');
//        $age = $request->input('age');
//        $gender = $request->input('gender');
//        $information_about = $request->input('information_about');
//


        $admin=Admin_model::create([
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'age'=>$request->input('age'),
            'gender'=>$request->input('gender'),
            'information_about'=>$request->input('information_about'),
            'password' => Hash::make($request->input('password')),
            'phone'=>$request->input('phone'),

            'image'=> $this->upload_image($request)

        ]);
        // session()->put('message','Admin added successfully' );

//        $token=$admin->createToken('authToken')->plainTextToken;
        // return redirect()->back();

    }

    public function upload_image(Request $request)
    {


        if ($request->hasFile("image")) {
            $files = $request->file("image");

                $filename = uniqid() . '.' . $files->getClientOriginalExtension();

                $files->move('public/Image/', $filename);

                $url = url('public/Image/' . $filename);

                return $url;
            }


         else return null;
    }


//    public function login(Request $request)
//    {
//        $validation = Validator::make($request->all(), [
//            'email' => 'required|email',
//            'password' => 'required|alphaNum'
//        ]);
//
//        if ($validation->fails()) {
//            return response()->json([
//                'success' => false,
//                'errors' => $validation->errors()
//            ], 422);
//        }
//
//        $credentials = $request->only('email', 'password');
//
//        if (!Auth::attempt($credentials)) {
//            return response()->json([
//                'success' => false,
//                'message' => 'Invalid credentials',
//                'token' => null
//            ], 401);
//        }
//
//        $user = User::where('email', $request->email)->first();
//        $token = $user->createToken('authToken')->plainTextToken;
//
//        return response()->json([
//            'success' => true,
//            'message' => 'Logged in',
//            'token' => $token
//        ], 200);
//    }


//
//    public function createAccount(Request $request)
//    {
//
//$accountNumber = $request->input('account_number');
//$user=$request->input('user');
//    // Check if the account already exists
//$existingAccount = Account_bank::where('number_account', $accountNumber)->first();
//if ($existingAccount) {
//return back();
//}
//
//// Create a new account
//$account = new Account_bank();
//$account->number_account = $accountNumber;
//$account->value_of_account = 0;
//$account->users_id=$user;
//$account->bank_id=1;
//$account->save();
//
//return back();
//}
//
//public function addMoney(Request $request)
//{
//    $accountNumber = $request->input('account_number');
//    $amount = $request->input('amount');
//
//    $account = Account_bank::where('number_account', $accountNumber)->first();
//
//    if (!$account) {
//        return back()->with('error', 'Account not found.');
//    }
//
//    $account->value_of_account += $amount;
//    $account->save();
//
//    return back()->with('Money added successfully.');
//}


    public function addbank(Request $request){

        $name=$request->input('name');
        $address=$request->input('address');
        $nameState=$request->input('nameState');

        $state=state_model::where('nameState','like',$nameState)->first();
        if($state){
            $stateId=$state->id;
            $location=location_model::where('state_id','=',$stateId)->where('address','like',$address)->first();
            if($location){
                $locationId=$location->id;
                $bank=Bank_model::create([
                    'location_id'=>$locationId,
                    'name'=>$name,
                    'address'=>$address

                ]);
                session()->put('message','Bank added successfully');
                return redirect()->back();
            }
            else{

                $location=location_model::create([
                    'address'=>$address,
                    'state_id'=>$stateId
                ]);
                $bank=Bank_model::create([
                    'location_id'=>$location->id,
                    'name'=>$name,
                    'address'=>$address

                ]);
                session()->put('message','Bank added successfully');

                return redirect()->back();
            }
        }
        else{
            $state=state_model::craete(['nameState'=>$nameState]);
            $stateId=$state->id;
            $location=location_model::where('state_id','=',$stateId)->where('address','like',$address)->first();
            if($location){
                $locationId=$location->id;
                $bank=Bank_model::create([
                    'location_id'=>$locationId,
                    'name'=>$name,
                    'address'=>$address

                ]);
                session()->put('message','Bank added successfully');

                return redirect()->back();
            }
            else{

                $location=location_model::create([
                    'address'=>$address,
                    'state_id'=>$stateId
                ]);
                $bank=Bank_model::create([
                    'location_id'=>$location->id,
                    'name'=>$name,
                    'address'=>$address

                ]);
                session()->put('message','Bank added successfully');

                return redirect()->back();
            }

        }

    }
    // public function inform(Request $request){
    //     $type_of_informing=$request['type_informing'];
    //     $iduser=auth()->user()->id;
    //     if($request['user_who_isinformed_about_Him']){

    //         $inform=inform_model::create([
    //             'users_id'=>$iduser,
    //             'admin_id'=>1,
    //             'property_special_id'=>null,
    //             'user_who_isinformed_about_Him'=>$request['user_who_isinformed_about_Him'],
    //             'type_of_informing'=>$request['type_of_informing']
    //         ]);
    //         return response()->json(["inform"=>$inform]);
    //     }

    //     if($request['property_special_id']){

    //         $inform=inform_model::create([
    //             'users_id'=>$iduser,
    //             'admin_id'=>1,
    //             'property_special_id'=>$request['property_special_id'],
    //             'user_who_isinformed_about_Him'=>null,
    //             'type_of_informing'=>$request['type_of_informing']
    //         ]);
    //         return response()->json(["inform"=>$inform]);

    //     }

    // }


    public function suspend(Request $request,$id)
    {
//        $id=$request['id'];
//        $duration=$request['duration'];
        $user = User::findOrFail($id);

        // Set the suspension details
        $user->suspended_at = Carbon::now();
        $user->suspension_duration = 15;
        $user->save();

        // Handle any additional suspension actions (e.g., logging out the user)
        session()->put('message','User blocked successfully');

        return redirect()->back();
//        return response()->json(['user suspend  successfully']);
    }

    public function unsuspend(Request $request,$id)
    {

//        $id=$request['id'];
        $user = User::findOrFail($id);

        // Check if the user is already unsuspended
        if ($user->suspended_at === null) {
            // User is already unsuspended, no further action required
            return redirect()->back();
        }

        // Remove the suspension details
        $user->suspended_at = null;
        $user->suspension_duration = null;
        $user->save();

        // Handle any additional unsuspension actions
        session()->put('message', 'User unblocked successfully');

        return redirect()->back();
//        return response()->json(['user unsuspend  successfully']);

    }



    public function update( Request $request ){
        $update=Admin_model :: find(auth()->user()->id);

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




}
