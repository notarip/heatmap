<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class NewsAggregation extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = json_decode($this->getSections());
        $news = json_decode($this->getNews());
        $agg = [];

        foreach ($news as $article){
            $categories = $article->categories;
            $category = $categories[0];
            if(array_key_exists($category , $agg)){
                $agg[$category]['count'] += 1;
            }else{
                $agg[$category]['count'] = 1;
                $agg[$category]['name'] = $this->getSectionName($sections,$category);
            }
        }

        return response()->json($agg);
    }

    private function getSectionName($sections, $id)
    {
        $name = "argentina";
        foreach ($sections as $section)
        {
            if ($section->data->id == $id)
            {
                $name = $section->data->slug;
                break;
           }
        }

        return $name;
    }

    private function getNews()
    {
        $client = new Client();
        $endpoint = env("NEWS_ENDPOINT");
        $res = $client->get($endpoint, array());
        return $res->getBody();
    }

    private function getSections()
    {
        $client = new Client();
        $endpoint = env("SECTIONS_ENDPOINT");
        $res = $client->get($endpoint, array());
        return $res->getBody();
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return "yes";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
