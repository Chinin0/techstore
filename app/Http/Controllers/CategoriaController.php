<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;


class CategoriaController extends Controller
{
    //

    function _construct(){
        $this->middleware('permission:ver-categoria|crear-categoria|editar-categoria|borrar-categoria', ['only'=>['index']]);
        $this->middleware('permission:crear-categoria', ['only'=>['create','store']]);
        $this->middleware('permission:editar-categoria', ['only'=>['edit','update']]);
        $this->middleware('permission:borrar-categoria', ['only'=>['destroy']]);
    }

    public function index()
    {
        $categorias = Categoria::paginate(10);

        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias.crear');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:categorias|max:50',
            'descripcion' => 'nullable',
            'estado' => 'boolean'
        ]);

        $categoria = new Categoria();
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->estado = $request->estado ?? true;
        $categoria->save();

        return redirect()->route('categorias.index')->with('success', 'Categoría creada correctamente.');
    }


    public function edit($id)
    {
        //
        $categoria = Categoria::find($id);

        return view('categorias.editar', compact('categoria'));
    }
    public function update(Request $request, $id)
    {
        //
        $this->validate($request, [
            'nombre' => 'required|unique:categorias|max:50',
            'descripcion' => 'nullable',
            'estado' => 'boolean'
       ]);

            $input = $request->all();

            $categoria =Categoria::find($id);
            $categoria -> update($input);


            return redirect()->route('categorias.index');
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
        $categoria = Categoria::find($id);
        Categoria::find($id)->delete();



        return redirect()->route('categorias.index');
    }




}
