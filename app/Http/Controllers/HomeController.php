<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {

        $client = new Client();

        $response = $client->request('GET', "https://api.themoviedb.org/3/trending/movie/day?api_key=".env('API_ENV')."&language=pt-BR&sort_by=original_title.asc");

        $list = $response->getBody();

        $listaNova = json_decode($list);

        uasort($listaNova->results, function ($a, $b) {
            return strcmp($a->title, $b->title);
        });

        $newResult = [];
        foreach($listaNova->results as $rst){
            $newResult[] = $rst;
        }

        $listaNova->results = $newResult;

        return response()->json($listaNova);
    }

    public function genres()
    {

        $client = new Client();

        $response = $client->request('GET', "https://api.themoviedb.org/3/genre/movie/list?api_key=".env('API_ENV')."&language=pt-BR");

        $list = $response->getBody();

        $novaLista = json_decode($list);

        uasort($novaLista->genres, function ($a, $b)
        {
            return strcmp($a->name, $b->name);
        });

        $novaLista->genres = $novaLista->genres;

        $newResult = [];
        foreach($novaLista->genres as $gen){
            $newResult[] = $gen;
        }

        $novaLista->genres = $newResult;

        return response()->json($novaLista);
    }

    public function movie($movie)
    {

        if(!$movie){
            return response()->status(400);
        }

        $client = new Client();

        $response = $client->request('GET', "https://api.themoviedb.org/3/movie/".$movie."?api_key=".env('API_ENV')."&language=pt-BR");

        $list = $response->getBody();

        return response()->json(json_decode($list));

    }

    public function search(Request $request)
    {
        $client = new Client();

        $querySearch = "";
        if($request->query('query')){
            $querySearch = "&query=" . $request->query('query');
        }

        $page = 1;
        if($request->query('page')){
            $page = $request->query('page');
        }

        if($request->query('genre') && !($request->query('query'))){
            $response = $client->request('GET', "https://api.themoviedb.org/3/discover/movie?api_key=".env('API_ENV')."&language=pt-BR&sort_by=popularity.asc&include_adult=false&include_video=false&page=".$page."&with_genres=" . $request->query('genre'));
        }else{
            $response = $client->request('GET', "https://api.themoviedb.org/3/search/movie?api_key=".env('API_ENV')."&language=pt-BR&page=".$page."&include_adult=false" . $querySearch);$response = $client->request('GET', "https://api.themoviedb.org/3/search/movie?api_key=".env('API_ENV')."&language=pt-BR&page=".$page."&include_adult=false" . $querySearch);
        }

        $list = $response->getBody();

        $novaLista = json_decode($list);

        if($request->query('genre') && $request->query('query')){

            $genreId = $request->query('genre');

            $novaLista->results = array_map(function($result) use($genreId){
                if(in_array($genreId, $result->genre_ids)){
                    return $result;
                }
            }, $novaLista->results);

        }

        uasort($novaLista->results, function ($a, $b) {
            if(isset($a->title) && isset($b->title)){
                return strcmp($a->title, $b->title);
            }
        });

        $newResult = [];
        foreach($novaLista->results as $rst){
            if($rst != null){
                $newResult[] = $rst;
            }
        }

        $novaLista->results = $newResult;

        return response()->json($novaLista);
    }

}
