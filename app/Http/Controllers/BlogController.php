<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//agregamos
use App\Models\Blog;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;


class BlogController extends Controller
{

    function _construct(){
        $this->middleware('permission:ver-blog|crear-blog|editar-blog|borrar-blog', ['only'=>['index']]);
        $this->middleware('permission:crear-blog', ['only'=>['create','store']]);
        $this->middleware('permission:editar-blog', ['only'=>['edit','update']]);
        $this->middleware('permission:borrar-blog', ['only'=>['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $blogs = Blog::paginate(10);
        return view('blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('blogs.crear');
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
        $this->validate($request, [
            'titulo'=> 'required',
            'contenido'=>'required']);

        Blog::create($request->all());


        return redirect()->route('blogs.index');
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
    public function edit(Blog $blog)
    {
        //
        return view('blogs.editar', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Blog $blog)
    {
        //
        request()->validate([
            'titulo'=> 'required',
            'contenido'=>'required']);

        $blog->update($request->all());


        return redirect()->route('blogs.index');
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
        Blog::delete();


        return redirect()->route('blogs.index');
    }



    ////recursos para la api

    public function index_api()
    {
        $blogs = Blog::all();

        return response()->json($blogs);
    }

    public function show_api($id)
    {
        $blogs = Blog::findOrFail($id);

        return response()->json($blogs);
    }

 public function store_api(Request $request)
    {
        $validatedData = $request->validate([
            'titulo' => 'required',
            'contenido' => 'required',
        ]);

        $post = Blog::create($validatedData);

        return response()->json($post, 201);
    }

    public function update_api(Request $request, $id)
    {
        $validatedData = $request->validate([
            'titulo' => 'required',
            'contenido' => 'required',
        ]);

        $post = Blog::findOrFail($id);
        $post->update($validatedData);

        return response()->json($post, 200);
    }

    public function destroy_api($id)
    {
        $post = Blog::findOrFail($id);
        $post->delete();

        return response()->json(null, 204);
    }
}
