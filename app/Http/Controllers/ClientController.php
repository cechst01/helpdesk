<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreClient;
use App\Http\Requests\UpdateClient;
use Request as Rqst;
use App\Traits;

class ClientController extends Controller
{
    use Traits\SearchTrait;
    /**
     * Zobrazeni formulare pro vytvoreni klienta adminem.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('client/create');
    }

    /**
     * Ulozeni noveho klienta do DB.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClient $request)
    {        
        $user = new User();
        $user->user_name = $request->user_name;
        $user->company_name = $request->company_name;
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->last_activity = date('Y-m-d');

        $user->save();

        $counts = $request->count ? $request->count : [];
        $datesFrom = $request->valid_from ? $request->valid_from : [];
        $datesTo = $request->valid_to ? $request->valid_to : [];

        $insertData = [];
        $date = date('Y-m-d H:i:s');

        foreach($counts as $index => $count){
            $from = $datesFrom[$index];
            $to = $datesTo[$index];
            $insertData[] = ['user_id' => $user->id,
                'count' => $count,
                'valid_from' => $from,
                'valid_to' => $to,
                'created_at' => $date,
                'updated_at' => $date];
        }


        $user->credits()->createMany($insertData);
        
        return redirect()->route('admin-clients')->with('success','Uživatel přidán.');

    }

    /**
     * Zobrazeni formulare pro editaci klienta adminem.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('client/edit')->with('user',$user);
    }

    /**
     * Update udaju klienta v DB.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function update(UpdateClient $request,$id)
    {
        $user = User::find($id);

        $user->enabled = isset($request->enabled) ? 1 : 0;
        $user->user_name = $request->user_name;
        $user->company_name = $request->company_name;
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;

        if(!empty($request->password)){
            $user->password = Hash::make($request->password);
        }

        $user->save();

        $user->credits()->delete();

        $counts = $request->count ? $request->count : [];
        $removedCounts = $request->removed_count ? $request->removed_count : [];
        $datesFrom = $request->valid_from ? $request->valid_from : [];
        $datesTo = $request->valid_to ? $request->valid_to : [];

        $insertData = [];
        $date = date('Y-m-d H:i:s');

        foreach($counts as $index => $count){
            $from = $datesFrom[$index];
            $to = $datesTo[$index];
            $removed = $removedCounts[$index];
            $insertData[] = ['user_id' => $user->id,
                'count' => $count,
                'removed_count' => $removed,
                'valid_from' => $from,
                'valid_to' => $to,
                'created_at' => $date,
                'updated_at' => $date];
        }

        $user->credits()->createMany($insertData);

        return redirect()->back()->with('success','Údaje byly uloženy.');
    }

    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $userId = $request->id;
        $approved = $request->approved;
        $user = User::find($userId);

        if($approved == 1){
            $variables = $this->searchApprovedTickets(Rqst::class,$user->id);
        }
        else{
            $variables = $this->searchTickets(Rqst::class,$user->id);
        }

        extract($variables);
        return view('client/detail',compact('user','tickets','types','states','searchValue','typeValue','stateValue'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        
        return redirect()->route('admin-clients')->with('success','Uživatel smazán.');
    }
    
    public function multipleDestroy(Request $request){
        $ids = $request->deletedClients;
        $clients = User::whereIn('id',$ids);
        $clients->delete();
        return redirect()->back()->with('success','Klienti byli smazáni.');
    }
}
