<?php

namespace App\Http\Controllers;

use Request;
use App\LoginHistory;

class LoginHistoryController extends Controller
{
    public function showHistory(){
        $itemsPerPage = 25;
        $searchValue = Request::get('search');

        $loginHistory = new LoginHistory();

        if($searchValue){

            $histories = LoginHistory::whereHas('user',function($query) use($searchValue){
                $query->where('user_name','LIKE','%'.$searchValue.'%');
            })->paginate($itemsPerPage);

            //$histories = $query->where('user_name','LIKE','%'.$searchValue.'%')->paginate($itemsPerPage);
        }
        else{
            $histories = $loginHistory->paginate($itemsPerPage);
        }

       return view('loginHistory/show')->with('histories',$histories);
    }
}
