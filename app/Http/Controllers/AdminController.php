<?php

namespace App\Http\Controllers;

use Request;
use App\User;
use App\TicketState;
use App\TicketType;
use App\Traits\SearchTrait;

class AdminController extends Controller
{
    use SearchTrait;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tickets()    {

        $approved = Request::get('approved');
        $deleted = Request::get('deleted');

        if($approved == 1){
            $variables = $this->searchApprovedTickets(Request::class,false,50);
        }
        elseif($deleted == 1){
            $variables = $this->searchDeletedTicket(Request::class,false,50);
        }
        else{
            $variables = $this->searchTickets(Request::class,false,50);
        }

        extract($variables);       
        return view('admin/ticketDashboard',compact('tickets','states','types','searchValue','typeValue','stateValue'));
    }
    
    public function clients(){
        
        $itemsPerPage = 10;
        
        $states = TicketState::all();
        $types = TicketType::all();
        
        $searchValue = Request::get('search');
        $obj = new User();
        $query = $obj->where('admin',0);
        if($searchValue){
           $clients = $query->where('user_name','LIKE','%'.$searchValue.'%')->paginate($itemsPerPage);
        }
        else{
           $clients = $query->paginate($itemsPerPage);
        }
        
        return view('admin/clientDashboard',compact('clients','states','types','searchValue'));
    }

}
