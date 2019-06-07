<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Mail;

class UsersController extends Controller
{
    private $folder = "admin.users.";
    public  $title;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $record = User::all();
        $this->title = "Usuarios";
        return view($this->folder."index",['record' => $record, 'title' => $this->title]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type = "new";
        $this->title = "Nuevo Usuario";
        return view($this->folder."save",['type' => $type, 'title' => $this->title]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'role' => 'required',
            'password' => 'required'
        ]);

        $object = new User();
        $object->name = $request->input('name');
        $object->email = $request->input('email');
        $object->phone = $request->input('phone');
        $object->role = $request->input('role');
        $object->password = bcrypt($request->input('password'));

        if($object->save()){

            $email_data = (object) array(
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => $request->input('password')
            );

            Mail::send('admin.emails.new_user', ['record' => $email_data], function ($m) use ($email_data) {
                $m->from('cvargas@frontuari.net', 'TveooTv Support');

                $m->to($email_data->email, $email_data->name)->subject('Nuevo Cliente');
            });

            flash("Registro insertado con Exito!!")->success();
        }else{
            flash("Error al insertar el Regisro!!")->error();
        }

        return redirect()->route('users.index');
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
        $record = User::findorfail($id);
        $type = "update";
        $this->title = "Editar Usuario";
        return view($this->folder."save",['type' => $type, 'record' => $record, 'title' => $this->title]);
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
         $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'role' => 'required'
        ]);

        $object = User::findorfail($id);
        $object->name = $request->input('name');
        $object->email = $request->input('email');
        $object->phone = $request->input('phone');
        $object->role = $request->input('role');

        if($object->update()){
            flash("Registro Actualizado con Exito!!")->success();
        }else{
            flash("Error al Actualizar el Regisro!!")->error();
        }

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $object = User::findorfail($id);
        if($object->delete()){
            flash("Registro eliminado con Exito!!")->success();
        }else{
            flash("Error al tratar de eliminar el Registro!!")->error();
        }

        return redirect()->route('users.index');
    }

    public function profile(){
        
    }

    public function user_change_password($id, Request $request){
        $request->validate([
            'password' => 'required'
        ]);

        $object = User::findorfail($id);
        $object->password = bcrypt($request->input('password'));

        if($object->update()){

            $email_data = (object) array(
                'name' => $object->name,
                'email' => $object->email,
                'password' => $request->input('password')
            );

            Mail::send('admin.emails.new_user', ['record' => $email_data], function ($m) use ($email_data) {
                $m->from('cvargas@frontuari.net', 'TveooTv Support');

                $m->to($email_data->email, $email_data->name)->subject('Actualizacon de Contraseña');
            });

            flash('Contrase&ntilde;a Actualizada con Exito!!')->success();

        }else{
            flash('Eror al tratar de Actualizar la Contrase&ntilde;a!!')->error();
        }

        return   redirect()->route('users.index');
    }
}
