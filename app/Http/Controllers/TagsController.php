<?php

namespace App\Http\Controllers;

use App\Lesson;
use App\Tag;
use App\Transformers\TagTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Response;

class TagsController extends ApiController
{
    protected $tagTransformer;

    /**
     * TagsController constructor.
     * @param $tagTransformer
     */
    public function __construct(TagTransformer $tagTransformer)
    {
        $this->tagTransformer = $tagTransformer;
    }


    /**
     * Display a listing of the resource.
     *
     * @param null $lessonId
     * @return \Illuminate\Http\Response
     */
    public function index($lessonId = null)
    {

        try {
            $tags = $this->getTags($lessonId);
        } catch(ModelNotFoundException $exception){
            return Response::json([
                'error' => ['message' => 'Resource not found']
            ], 404);
        }

        return $this->respond([
            'data' => $this->tagTransformer->transformCollection($tags->toArray())
        ]);
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
        //
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

    /**
     * @param $lessonId
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    private function getTags($lessonId)
    {
        $tags = $lessonId ? Lesson::findOrFail($lessonId)->tags : Tag::all();
        return $tags;
    }
}
