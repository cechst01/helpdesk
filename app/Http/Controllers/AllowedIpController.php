<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AllowedIpAddress;
use App\Http\Requests\UpdateIpAddresses;

class AllowedIpController extends Controller
{
    public function edit(){
        $allowedIpAddress = AllowedIpAddress::all();
        return view('allowedIp/edit')->with('allowedIps',$allowedIpAddress);
    }

    public function update(UpdateIpAddresses $request){
        $ipAddresses = isset($request->allowedIp) ? $request->allowedIp : [];
        $insertData = [];
        AllowedIpAddress::query()->delete();

        foreach($ipAddresses as $ip){
            $insertData[] = ['ip_address' => $ip];
        }

        if($insertData){
            $allowedIpAddress = new AllowedIpAddress;
            $allowedIpAddress->insert($insertData);
        }

        return redirect()->route('edit-allowed-ip')->with('success','Ip adresy byly uloženy');
    }
}
