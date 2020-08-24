<?php 
namespace App\Traits;
use App\Ticket;
use App\TicketState;
use App\TicketType;

trait SearchTrait
{
    public function searchTickets($request,$userId = false, $itemsPerPage = 10){

        $exceptStates = ['Smazáno','Vyřízeno'];

        $searchValue = $request::get('search');
        $typeValue = $request::get('type');
        $stateValue = $request::get('state');

        $state = new TicketState();
        $states = $state->getStatesWithout($exceptStates);
        $types = TicketType::all();

        $tickets = $this->getFilterTickets($searchValue,$typeValue,$stateValue,$exceptStates,$userId)->paginate($itemsPerPage);

        return ['states' => $states,'types' => $types,'searchValue' => $searchValue,'typeValue' => $typeValue,'stateValue' => $stateValue, 'tickets' => $tickets];
    }

    public function searchApprovedTickets($request,$userId = false,$itemsPerPage = 10){

        $exceptStates = ['Nový','Ke Zpracování','Zamítnuto','Reklamace','Zpracovává se','Schválení rozpočtu','Rozpočet schválen','Kontrola zákazníkem','Připomínka','Smazáno'];

        $searchValue = $request::get('search');
        $typeValue = $request::get('type');
        $stateValue = $request::get('state');
        $state = new TicketState();
        $states = $state->getStatesWithout($exceptStates);
        $types = TicketType::all();

        $tickets = $this->getFilterTickets($searchValue,$typeValue,$stateValue,$exceptStates,$userId)->paginate($itemsPerPage);

        return ['states' => $states,'types' => $types,'searchValue' => $searchValue,'typeValue' => $typeValue,'stateValue' => $stateValue, 'tickets' => $tickets];

    }

    public function searchDeletedTicket($request,$userId = false, $itemsPerPage = 10){

        $exceptStates = ['Nový','Ke Zpracování','Zamítnuto','Reklamace','Zpracovává se','Schválení rozpočtu','Rozpočet schválen','Kontrola zákazníkem','Připomínka','Vyřízeno'];

        $searchValue = $request::get('search');
        $typeValue = $request::get('type');
        $stateValue = $request::get('state');
        $state = new TicketState();
        $states = $state->getStatesWithout($exceptStates);
        $types = TicketType::all();

        $tickets = $this->getFilterTickets($searchValue,$typeValue,$stateValue,$exceptStates,$userId)->paginate($itemsPerPage);

        return ['states' => $states,'types' => $types,'searchValue' => $searchValue,'typeValue' => $typeValue,'stateValue' => $stateValue, 'tickets' => $tickets];
    }

    private function getFilterTickets($searchValue, $typeValue, $stateValue, $exceptStates, $userId = false){

        $ticket = new Ticket();

        $query = $ticket->getTicketsWithoutStates($exceptStates);

        if($userId){
            $query->where('user_id',$userId);
        }
        if($typeValue){
            $query->where('type_id',$typeValue);
        }
        if($stateValue){
            $query->where('state_id',$stateValue);
        }
        if($searchValue){
            $query->where('title','LIKE','%'.$searchValue.'%')
                ->orWhere('id',$searchValue);
        }

        return $query->orderBy('id','desc');


    }
}
    
