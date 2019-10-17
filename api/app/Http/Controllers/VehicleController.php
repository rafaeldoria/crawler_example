<?php

namespace App\Http\Controllers;

use App\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Vehicle::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        
        foreach ($data as $key => $value) {
            $km = explode(" ",$value['elementKm'])[0];
            $km = number_format(floatval($km), 3);
            $price = explode(" ",$value['elementPrice'])[1];
            $price = number_format(floatval($price), 3);
            $data = [
                'title' => $value['elementTitle'],
                'subtitle' => $value['elementSubtitle'],
                'year' => $value['elementYear'],
                'km' => $km,
                'price' => $price,
                'link' => $value['elementLink']
            ];
            Vehicle::create($data);
        }
        return "success";
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Vehicle::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function edit(Vehicle $vehicle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehicle $vehicle)
    {
        //
    }

    public function filters(Request $request)
    {
        $title = $request->input('title');
        $year = $request->input('year');
        $km_init = $request->input('km_init');
        $km_end = $request->input('km_end');
        $price_min = $request->input('price_min');
        $price_max = $request->input('price_max');

        if($title == ""){
            return false;
        }
        if($year == ""){
            $year = '2010';
        }
        if($km_init == ""){
            $km_init = 0;
        }
        if($km_end == ""){
            $km_end = 200;
        }
        if($price_min == ""){
            $price_min = 0;
        }
        if($price_max == ""){
            $price_max = 200;
        }

        $vehicles = Vehicle::where([
            ['title','like','%'.$title.'%'],
            ['year','like','%'.$year.'%'],
            ['km','>', $km_init],
            ['km','<', $km_end],
            ['price','>', $price_min],
            ['price','<', $price_max]
        ])->get();

        return $vehicles;

    }
}
