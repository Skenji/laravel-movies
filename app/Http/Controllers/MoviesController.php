<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Models\Movies;
use App\Http\Resources\MoviesResource;

class MoviesController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        # Define OMDB URL
        # We read the Information to show in the index page
        $omdbURL = "http://www.omdbapi.com/?s=avengers&type=movie&apikey=" . env("MIX_OMDB_KEY");
        $omdbResponse = Http::get($omdbURL);
        $objMovies = json_decode($omdbResponse);

        # if user is logged in we store imdbIDs to see if they match with a favorite movie
        $userid = Auth::id();
        if(!empty($userid)) {
            $moviesResult = Movies::where('user_id', $userid)->get();
            $favoriteIDs = array();
            foreach($moviesResult AS $movie) {
                $movieAttributes = $movie->getAttributes();
                $favoriteIDs[$movieAttributes["imdbID"]] = $movieAttributes["id"];
            }
            $request->session()->forget('favoriteIDs');
            $request->session()->put('favoriteIDs', $favoriteIDs);
        }
        
        return view('index', array(
            "movies" => $objMovies->Search,
            "token" => Session::token()
        ));
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        # Define OMDB URL
        # We read the Information to show in the search page
        $searchTerm = $request->input("query");
        $omdbURL = "http://www.omdbapi.com/?s={$searchTerm}&type=movie&apikey=" . env("MIX_OMDB_KEY");
        $omdbResponse = Http::get($omdbURL);
        $objMovies = json_decode($omdbResponse);

        # if user is logged in we store imdbIDs to see if they match with a favorite movie
        $userid = Auth::id();
        if(!empty($userid)) {
            $moviesResult = Movies::where('user_id', $userid)->get();
            $favoriteIDs = array();
            foreach($moviesResult AS $movie) {
                $movieAttributes = $movie->getAttributes();
                $favoriteIDs[$movieAttributes["imdbID"]] = $movieAttributes["id"];
            }
            $request->session()->forget('favoriteIDs');
            $request->session()->put('favoriteIDs', $favoriteIDs);
        }
        
        return view('index', array(
            "movies" => ($objMovies->Response == true && isset($objMovies->Search))? $objMovies->Search : NULL,
            "token" => Session::token()
        ));
    }

    /**
     * Handle the incoming request.
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
            $movies[] = $movie;
        }
        
        return view('index', array(
            "movies" => $movies,
            "boolFromDB" => true,
        ));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'imdbID' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'year' => 'required|digits:4',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $movie = Movies::create([
            'imdbID' => $request->imdbID,
            'title' => $request->title,
            'year' => $request->year,
            'poster' => empty($request->poster)? "" : $request->poster,
            'user_id' => Auth::id(),
         ]);
        
        return response()->json(array( "result" => true, "message" => 'Movie created successfully.', "info" => new MoviesResource($movie)));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id' => 'required|numeric|digits_between:1,11',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $movie = Movies::find($request->id);

        Movies::destroy($request->id);

        return response()->json(array( "result" => true, "message" => 'Movie deleted successfully.', "info" => new MoviesResource($movie)));
    }
}
