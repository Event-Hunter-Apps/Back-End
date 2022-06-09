<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Tiket;
use App\Models\Event;
class ApiTiketController extends Controller
{
    public function getAllTickets($id)
    {
        $event = Event::find($id);
        if (!$event) {
            return response([
                "message" => "event not found!"
            ], 400);
        }
        $tickets = Tiket::with(['kategori'])->where('event_id','=',$id)->get();
        if (!$tickets) {
            return response([
                "message" => "ticket not found!"
            ], 400);
        }
        return response([
            "message"=>"success get all tikets",
            "event"=>$event,
            "tikets"=>$tickets,
        ], 200);
    }

    public function getTicket($id)
    {
        $ticket = Tiket::with(['kategori', 'event'])->find($id);
        if (!$ticket) {
            return response([
                "message" => "ticket not found!"
            ], 400);
        }
        return [
            "message"=>"sucess get tiket",
            "tiket"=>$ticket
        ];
    }

    // public function createTicket(Request $request, $id)
    // {
    //     $validator = $request->validate([
    //         "kategori_id" => 'required',
    //         "nama" => 'required', 
    //         "deskripsi" => 'required',
    //         "harga" => 'required|integer'
    //     ]);

    //     $ticket = Tiket::Create([
    //         'event_id' => $eid,
    //         'kategori_id' => $validator['kategori'],
    //         'nama' => $validator['nama'],
    //         'deskripsi' => $validator['deskripsi'],
    //         'harga' => $validator['harga']
    //     ]);
    //     return [
    //         "message"=>"success create tiket",
    //         "tiket"=>$ticket,
    //     ];
    // }

    // public function update(Request $request, $id)
    // {
    //     $ticket = Tiket::find($id);
    //     if (!$tickets) {
    //         return response([
    //             "message" => "ticket not found!"
    //         ], 400);
    //     }
    //     $validator = $request->validate([
    //         "kategori_id" => 'required',
    //         "nama" => 'required', 
    //         "deskripsi" => 'required',
    //         "harga" => 'required|integer'
    //     ]);

    //     $ticket->update($request->all());
    //     return [
    //         "message"=>"success update tiket",
    //         "tiket"=> $ticket,
    //     ];
    // }

    // public function destroy($id)
    // {
    //     $response = Tiket::find( $id );
    //     $response->delete();
    //     return [
    //         "message"=>"success delete tiket",
    //         "tiket"=>$response,
    //     ];
    // }
}
