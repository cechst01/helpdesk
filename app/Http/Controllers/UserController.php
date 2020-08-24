<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Request as Rqst;
use App\Traits\SearchTrait;
use App\Http\Requests\UpdateUser;

class UserController extends Controller
{
    use SearchTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $approved = $request->approved;
        $user = User::find(Auth::user()->id);

        if($user->admin == 1){
            return redirect()->route('admin-tickets');
        }

        if($approved == 1){
            $variables = $this->searchApprovedTickets(Rqst::class,$user->id);
        }
        else{
            $variables = $this->searchTickets(Rqst::class,$user->id);
        }

        extract($variables);
        return view('user/dashboard',compact('user','tickets','types','states','searchValue','typeValue','stateValue'));
    }

    /**
     * Formular pro editaci udaju uzivatele.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('user/edit')->with('user',$user);
    }

    /**
     * Update udaju uzivatele v DB.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function update(UpdateUser $request)
    {
        $userId = Auth::user()->id;
        $user = User::find($userId);
       
        
        $user->user_name = $request->user_name;
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        
        if(!empty($request->password)){
            if(Hash::check($request->old_password, $user->password)){
                $user->password = Hash::make($request->password);
            }
            else{
                return redirect()->route('update-user',['id' => $userId])->with('error','Původní heslo nesouhlasí.');
            }
        }
        $user->save();
        return redirect()->route('update-user',['id' => $userId])->with('success','Údaje byly změněny');       
    }


}
