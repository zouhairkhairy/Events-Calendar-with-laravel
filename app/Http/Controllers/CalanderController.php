<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class CalanderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
            if($request->ajax()){
                $data = Event::whereDate('start', '>=', $request->start)
                       ->whereDate('end',   '<=', $request->end)
                       ->get(['id', 'title', 'start', 'end']);
            return response()->json($data);
            }

        return view('calander');
    }

    public function action(Request $request)
    {
        if($request->ajax())
        {
            if($request->type == 'add')
            {
                $event = Event::create([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                ]);
                return response()->json($event);
            }

            if($request->type == 'update')
            {
                $event = Event::find($request->id)([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                ]);
                return response()->json($event);
            }
            if($request->type == 'delete')
            {
                $event = Event::find($request->id)->delete();
                return response()->json($event);
            }
            
        }
    }

}
