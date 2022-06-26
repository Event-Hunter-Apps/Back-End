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
}
