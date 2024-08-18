<?php

namespace App\Http\Controllers;

use App\Models\location_model;
use App\Models\property_special_model;
use App\Models\state_model;
use App\Models\favorate_model;
use App\Models\rate_property_model;
use App\Models\Bank_model;
use App\Models\Account_bank;
use App\Models\selles_model;
use App\Models\rents_model;



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

class BankController extends Controller
{
    
public function add_bank(Request $request){
    $data=Validator::make($request->all(),[
 'name'=>'required',
  'nameState'=>'required',
  'address'=>'required'      

    ]);
    if($data->fails()){
        return Response()->json([$data->errors()]);
    }
$name=$request['name'];
$address=$request['address'];
$nameState=$request['nameState'];
$state=state_model::where('nameState','=',$nameState)->first();
    $stateId=$state->id;
$location=location_model::where('state_id','=',$stateId)->where('address','=',$address)->first();
if($location){
    $locationId=$location->id;
    $bank=Bank_model::create([
        'location_id'=>$locationId,
        'name'=>$name,
        'address'=>$address
        
    ]);
return response()->json(['bank'=>$bank,'state'=>$state,'location'=>$location]);
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
        return response()->json(['bank'=>$bank,'state'=>$state,'location'=>$location]);
}
}
public function create_bank_account(Request $request){
    $data=Validator::make($request->all(),[
        'name'=>'required',
         'address'=>'required'      
       
           ]);
           if($data->fails()){
               return Response()->json([$data->errors()]);
           }
 $name=$request['name'];
 $address=$request['address'];

 $bank=Bank_model::where('name','=',$name)->where('address','=',$address)->first();
 if(!$bank){
    return response()->json(['not found bank with this data']);
 }
 $bankId=$bank->id;
 $userid=auth()->user()->id;

//  $length = 0; 
// $randomString = Str::random(); 

$randomNumber = rand(100000, 999999); 
$accountNumber = 'AC' .$randomNumber ;
$bankAccount=Account_bank::create([
    'users_id'=>$userid,
    'bank_id'=>$bankId,
    'number_account'=>$accountNumber,
    'value_of_account'=>0
]);
return response()->json(['bank account'=>$bankAccount]);
}
public function show_my_account(){
    $userid=auth()->user()->id;
    $account=Account_bank::where('users_id','=',$userid)->get();
    if(!$account->isEmpty())
    return Response()->json(['result'=>$account[0]]);

    return Response()->json(['result'=>null]);
}

public function recharge_my_account( Request $request )
{
    $data=Validator::make($request->all(),[
      'number_account'=>'required',
      'value_of_charge'=>'required'
        
    ]);        
           if($data->fails()){
               return Response()->json([$data->errors()]);
           }
           
           $userid=auth()->user()->id;
           $numberAccount=$request['number_account'];
           $valueCharge=$request['value_of_charge'];

           if(!Auth::guard('account')->attempt($request->only(['users_id'=>$userid,'number_account'=>$numberAccount]),true)){
            if(!Account_bank::where('users_id','=',$userid)->first()){
            return Response()->json(['message'=>'error  bank not found']);

            }
            if(!Account_bank::where('number_account','=',$numberAccount)->first()){
                return Response()->json(['message'=>'error  bank not found']);
    
                }
           }
        $account=Account_bank::where('users_id','=',$userid)->where('number_account','=',$numberAccount)->first();
           
           $accountNew=Account_bank::find($account->id);
           $accountNew->value_of_account+=$valueCharge;
           $accountNew->save();
        return Response()->json(['done successfuly','new account'=>$accountNew]);

}

public function buy(Request $request){  
    //required id property , number account buyer user ,token buyer user
$userid=auth()->user()->id;
$idproperty=$request['id_property'];
$numberAccount=$request['number_account'];

$bank_account1=Account_bank::where('users_id','=',$userid)->where('number_account','=',$numberAccount)->first();
if($bank_account1){
$value_of_account1=$bank_account1->value_of_account;
}
else{
    return response()->json(['message'=>'buyer dont have any bank account']);
}

$property=property_special_model::find($idproperty);
if($property->wasSell_or_wasRented =='wasSell'){
    return response()->json(['message'=>'this property was sold so you can not buy it']);
}
if($property->rent_or_sell=='rent'){
    return response()->json(['message'=>'this property is rent  so you can not sell it']);
}
$userid2=$property->users_id;
$price=$property->price;
if($value_of_account1 < $price){
return response()->json(['message'=>'You do not have enough balance in your bank account to buy this property']);
}
$bank_account2=Account_bank::where('users_id','=',$userid2)->first();
if($bank_account2){
    $numberAccountSeller=$bank_account2->number_account;
    $value_of_account2=$bank_account2->value_of_account;

}
else{
    return response()->json(['message'=>'seller dont have any bank account']);
}


 $bank_account1->value_of_account-=$price;
 $bank_account1->save();
 $bank_account2->value_of_account+=$price;
 $bank_account2->save();
 $property->wasSell_or_wasRented='wasSell';
 $property->save();

 $sell=selles_model::create([
'users_id'=>$userid2,
'id_buyer'=>$userid,
'property_special_id'=>$idproperty
 ]);


 return response()->json(['message'=>'sell operation was done successfully',$sell]);
}


public function rent(Request $request){  
    //required id property , number account buyer user ,token buyer user
$userid=auth()->user()->id;
$idproperty=$request['id_property'];
$numberAccount=$request['number_account'];

$bank_account1=Account_bank::where('users_id','=',$userid)->where('number_account','=',$numberAccount)->first();
if($bank_account1){
$value_of_account1=$bank_account1->value_of_account;
}
else{
    return response()->json(['buyer dont have any bank account']);
}

$property=property_special_model::find($idproperty);
if($property->wasSell_or_wasRented=='wasRented'){
    return response()->json(['message'=>'this property was rented so you cant rent this']);
}
if($property->rent_or_sell=='sell'){
    return response()->json(['message'=>'this property is sell  so you cant rent this']);
}
$userid2=$property->users_id;
$monthlyRent=$property->monthlyRent;
if($value_of_account1 < $monthlyRent){
return response()->json(['you dont have in your account enough money to  rent this proprty']);
}
$bank_account2=Account_bank::where('users_id','=',$userid2)->first();
if($bank_account2){
    $numberAccountSeller=$bank_account2->number_account;
    $value_of_account2=$bank_account2->value_of_account;

}
else{
    return response()->json(['renter dont have any bank account']);
}


 $bank_account1->value_of_account-=$monthlyRent;
 $bank_account1->save();
 $bank_account2->value_of_account+=$monthlyRent;
 $bank_account2->save();
 $property->wasSell_or_wasRented='wasRented';
 $property->save();

 $rent=rents_model::create([
'users_id'=>$userid2,
'id_rent_user'=>$userid,
'property_special_id'=>$idproperty
 ]);


 return response()->json(['rent operation was done successfully',$rent]);
}

///web

public function loginb(Request $request)
{
    $credentials = $request->only('email', 'password');
//dd($credentials);

    if (Auth::guard('web')->attempt($credentials)) {
//
        return redirect()->route('Bankdashboard');
    } else {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            session()->put('error', 'Invalid email');
            return redirect()->back();
        } else {
            session()->put('error', 'Invalid password');
            return redirect()->back();
        }

    }
}
public function logoutb(Request $request)
{

    Auth::logout();
    return redirect('Bank');
}

public function showBalance(Request $request)
{
    $user=Auth::user();
//    $accountNumber = $request->input('account_number');

    $accounts = Account_bank::where('users_id', $user->id)->get();

    if (!$accounts->isEmpty()) {
        $a=[];
        foreach ($accounts as $account){
            $accountNumber=$account->number_account;
            $balance = $account->value_of_account;
            $bank_id=$account->bank_id;
            $bank=Bank_model::find($bank_id)->name;
            $a[]= (object)(['accountNumber'=>$accountNumber,'bank'=>$bank,'balance'=>$balance]);
        }

        return view('Bank.show-account',['accounts' => $a]);
    } else {
        return view('Bank.show-account',['accounts'=>[]]);

    }
}


public function banks()
{
    // Retrieve bank information from the database
    $banks = Bank_model::all();
    $b=[];
    foreach ($banks as $bank)
    {
        $location_id=$bank->location_id;
        $location=location_model::find($location_id);
        $location1=$location->address;
        $state=state_model::find($location->state_id)->nameState;
        $b[]=array(
            "Id"=>$bank->id,
            "name"=>$bank->name,
            "location"=>$location1,
            "state"=>$state,
        );

    }

    // Pass the bank information to the dashboard view
    return view('Bank.Bankdashboard', compact('b'));
}

public function createAccount(Request $request)
{
    $bankId = $request->input('bankId');
    $amount = $request->input('amount');
    $password=$request->input('password');
    $user=Auth::user()->id;

    $bank = Bank_model::where('id', $bankId)->first();
    if (!$bank) {
        session()->put('bankIdInvalid', true);
        return redirect()->back();    }

    $accountNumber = $this->generateAccountNumber();

    Account_bank::create([
        'bank_id' => $bankId,
        'number_account' => $accountNumber,
        'value_of_account' => $amount,
        'account_password'=>Hash::make($password),
        'users_id' => $user,
    ]);

    session()->put('accountNumber', $accountNumber);
    session()->put('password',$password);

    return redirect()->back();
}

private function generateAccountNumber()
{
    $accountNumber = mt_rand(1000000, 9999999);


    $existingAccount = Account_bank::where('number_account', $accountNumber)->first();
    if ($existingAccount) {
        return $this->generateAccountNumber();
    }

    return $accountNumber;
}

public function addMoney(Request $request)
{


    $accountNumber = $request->input('account_number');
    $password=$request->input('account_password');
    $amount = $request->input('amount');
    $user=Auth::user();
//    dd($user->id);
    $accounts = Account_bank::where('users_id', $user->id)->pluck('number_account')->toArray();
    if(!$accounts){
        session()->put('error','You have no bank accounts');
        return redirect()->back();
    }
//       if ( $account->number_account !== $accountNumber) {
//
//            session()->put('AccountNumberInvalid', true);
//            return redirect()->back();
//        }
    if (!in_array($accountNumber, $accounts)) {
        session()->put('AccountNumberInvalid', true);
        return redirect()->back();
    }
    $account = Account_bank::where('number_account', $accountNumber)->first();
//        dd(Hash::make($password));
    if (Hash::check($password , $account->account_password)) {
        session()->put('PasswordInvalid', true);
        return redirect()->back();
    }

//        if (! $account->account_password = $password)
//        {
//            session()->put('PasswordInvalid',true);
//            return redirect()->back();
//        }

//
//        if(!Auth::guard('account')->attempt($request->only(['users_id'=>$user,'number_account'=>$accountNumber,'account_password'=>$password]),true)){
//            if(!Account_bank::where('users_id','=',$user)->first()){
//                session()->put('error','Enter');
//
//            }
//            if(!Account_bank::where('number_account','=',$numberAccount)->first()){
//                return Response()->json(['message'=>'error  bank not found']);
//
//            }
//        }
    $account = Account_bank::where(['users_id'=>$user->id,'number_account'=> $accountNumber])->first();
//        if (!$account) {
//            session()->put('AccountNumberInvalid', true);
//            return redirect()->back();    }

    $account->value_of_account +=$amount;
    $account->save();


    session()->put('message', 'the money is added to your balance');

    return redirect()->back();
}



}