<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Event;

use DB;
class ApiEventController extends Controller
{
    public function getAllEvents()
    {   
        $nama = request()->query('nama') ? request()->query('nama') : '';
        $kota = request()->query('kota') ? request()->query('kota') : '';
        

        // dd($nama);
        $events = DB::table('events')
        ->where('nama', 'LIKE', '%'.$nama.'%')
        ->where('kota', 'LIKE', '%'.$kota.'%')
        ->get();
        
        // $events = Event::latest()->filter(request(['nama', 'kota']))->get();;
        if(!$events) {
            return response([
                "message"=>"bad request",
            ], 400);
        }
        return response([
            "message"=>"success get all events",
            "events"=>$events,
            "url" => url()->full(),
        ], 200);
    }

    public function getAllEventsTrending()
    {   
        $nama = request()->query('nama') ? request()->query('nama') : '';
        $kota = request()->query('kota') ? request()->query('kota') : '';
        

        // dd($nama);
        $events = DB::table('events')
        ->where('nama', 'LIKE', '%'.$nama.'%')
        ->where('kota', 'LIKE', '%'.$kota.'%')
        ->orderByDesc('events.created_at')
        ->limit(3)
        ->get();
        
        // $events = Event::latest()->filter(request(['nama', 'kota']))->get();;
        if(!$events) {
            return response([
                "message"=>"bad request",
            ], 400);
        }
        return response([
            "message"=>"success get all events",
            "events"=>$events,
            "url" => url()->full(),
        ], 200);
    }

    public function getEvent($id)
    {
        $event = Event::find($id);
        if(!$event) {
            return response([
                "message"=>"bad request",
            ], 400);
        }
        return response([
            "message"=>"success get event",
            "events"=>$event,
        ], 200);
    }
}
