<?php

namespace App\Http\Controllers\API;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Movies;
use App\Http\Resources\MoviesResource;

class MoviesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        # We lookup for the movies by user_id
        $userid = Auth::id();
        $moviesResult = Movies::where('user_id', $userid)->get();

        $movies = array();
        foreach($moviesResult AS $movie) {
            $movies[] = new MoviesResource($movie);
        }
        
        return response()->json(array("movies" => $movies));
    }
}
