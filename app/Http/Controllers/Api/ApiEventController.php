<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Event;
class ApiEventController extends Controller
{
    public function getAllEvents()
    {
        $events = Event::all();
        if(!$events) {
            return response([
                "message"=>"bad request",
            ], 400);
        }
        return response([
            "message"=>"success get all events",
            "events"=>$events,
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
            "message"=>"success get all events",
            "events"=>$event,
        ], 200);
    }

    public function createEvent(Request $request)
    {
        $validator = $request->validate([
            'nama'=>'required|string',
            'deskripsi' => 'required|string',
            'tanggal_mulai' => 'required',
            'tanggal_berakhir' => 'required',
            'jam_buka' => 'required',
            'jam_tutup' => 'required',
            'lokasi' => 'required',
            'kota' => 'required',
            'harga' => 'required|integer',
            'image_upload' => 'image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $filename = '';
        if($request->hasFile('image_upload')) {
            $image = $request->file('image_upload'); //image file from frontend
            $firebase_storage_path = 'Events/';
            $localfolder = public_path('firebase') .'/';
            $extension = $image->getClientOriginalExtension();
            $file      = time(). '.' . $extension;
            $filename = $firebase_storage_path . $file;
            if ($image->move($localfolder, $file)) {
                try {
                    $uploadedfile = fopen($localfolder.$file, 'r');
                    app('firebase.storage')->getBucket()->upload($uploadedfile, ['name' => $firebase_storage_path . $file]);
                    unlink($localfolder . $file);
                } catch (exception $e) {
                    return response([
                        "message"=>"success create event",
                        "event" => $e,
                    ], 200);
                }
            }   
        }

        $event = Event::create([
            'user_id'=> auth()->user()->id,
            'nama'=> $validator['nama'],
            'deskripsi' => $validator['deskripsi'],
            'tanggal_mulai' => $validator['tanggal_mulai'],
            'tanggal_berakhir' => $validator['tanggal_berakhir'],
            'jam_buka' => $validator['jam_buka'],
            'jam_tutup' => $validator['jam_tutup'],
            'lokasi' => $validator['lokasi'],
            'kota' => $validator['kota'],
            'harga' => $validator['harga'],
            'image' => $filename
        ]);

        return response([
            "message"=>"success create event",
            "event" => $event,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::find($id);
        if (!$event) {
            return response([
                "message"=>"invalid id",
            ], 400);
        }
        return response([
            "message"=>"sucess get event",
            "event"=>$event,
        ], 200);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $event = Event::find($id);
        if (!$event) {
            return response([
                "message"=>"invalid id",
            ], 400);
        }
        $event->update($request->all());
        return response([
            "message"=>"success update event",
            "event"=> $event,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::find($id);
        if (!$event) {
            return response([
                "message"=>"invalid id",
            ], 400);
        }
        $event->delete();
        return response([
            "message"=>"success delete event",
            "event"=>$event,
        ], 200);
    }
}
