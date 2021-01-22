<?php

namespace App\Http\Controllers;

use App\Empleados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class EmpleadosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $datos['empleados']=Empleados::paginate();
        return view('empleados.index',$datos);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('empleados.create');

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

        $campos=[
            'Nombre' => 'required|string|max:100',
            'ApellidoPaterno' => 'required|string|max:100',
            'ApellidoMaterno' => 'required|string|max:100',
            'Correo' => 'required|string|max:100',
            'Foto' => 'required|max:10000|mimes:jpeg,png,jpg'
        ];

        $Mensaje=["required"=>'El :attribute es requerido'];

        $this->validate($request,$campos,$Mensaje);


    // $datosEmpleado=request()->all();

        //esto nos sirve para recolectar la informacion y que sea igual al de la tabla
         $datosEmpleado=request()->except('_token');

         if ($request->hasFile('Foto')) {

                $datosEmpleado['Foto']=$request->file('Foto')->Store('uploads','public');

         }

         Empleados::insert($datosEmpleado);



        //return response()->json($datosEmpleado);

        return redirect('empleados')->with('Mensaje','Empleado agregado con éxito');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Empleados  $empleados
     * @return \Illuminate\Http\Response
     */
    public function show(Empleados $empleados)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Empleados  $empleados
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $empleado= Empleados::findOrFail($id);

        return view('empleados.edit',compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Empleados  $empleados
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $campos=[
            'Nombre' => 'required|string|max:100',
            'ApellidoPaterno' => 'required|string|max:100',
            'ApellidoMaterno' => 'required|string|max:100',
            'Correo' => 'required|string|max:100',
        ];

        if ($request->hasFile('Foto')) {
            $campos+=['Foto' => 'required|max=10000|mines:jpeg,png,jpg'];

        }
        
        $Mensaje=["required"=>'El :attribute es requerido'];

        $this->validate($request,$campos,$Mensaje);

        // se tiene que seguir este orden ya que primero busca la foto, luego hace la condicion
        //y si hace la condicion ya pasa a actualizar
        $datosEmpleado=request()->except(['_token','_method']);

         if ($request->hasFile('Foto')) {
        
                $empleado= Empleados::findOrFail($id);

                Storage::delete('public/'.$empleado->Foto);

                $datosEmpleado['Foto']=$request->file('Foto')->Store('uploads','public');

         }


        Empleados::where('id','=',$id)->update($datosEmpleado);

        //aqui recuperamos la informacion actualizado
        //$empleado= Empleados::findOrFail($id);
        //return view('empleados.edit',compact('empleado'));

        return redirect('empleados')->with('Mensaje','Empleado modificado con éxito');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Empleados  $empleados
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $empleado= Empleados::findOrFail($id);

        if (Storage::delete('public/'.$empleado->Foto)) {
            Empleados::destroy($id);

        }

        //return redirect('empleados');
        return redirect('empleados')->with('Mensaje','Empleado eliminado con éxito');

    }
}


