<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Message;
use App\User;
use Auth;

class MessagesController extends Controller
{
    private $folder = "admin.messages.";
    public  $title;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $record = Message::all();
        $this->title = "Mensajes";
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
        $this->title = "Nuevo Mensaje";

        $customers = User::where('role','=','customer')->get();
        if(!isset($customers) and empty($customers)){
            $customers = [];
        }

        return view($this->folder."save",['type' => $type, 'title' => $this->title, 'customers' => $customers]);
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
            'title' => 'required',
            'description' => 'required',
            'content' => 'required'
        ]);

        $object = new Message();
        $object->user_id = Auth::user()->id;
        $object->title = $request->input('title');
        $object->description = $request->input('description');
        $object->content = $request->input('content');

        if($request->hasFile('cover')){
            $object->cover = $request->cover->store("messages/covers");
        }else{
            $object->cover = NULL;
        }

        if($object->save()){
            flash("Registro insertado con Exito!!")->success();
        }else{
            flash("Error al insertar el Regisro!!")->error();
        }

        return redirect()->route('messages.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $record = Message::findorfail($id);
        Storage::delete($record->cover);
        $record->cover = NULL;
        $record->update();

        print json_encode(['deleted' => 'yes']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $record = Message::findorfail($id);
        $type = "update";
        $this->title = "Editar Mensaje";
        $customers = User::where('role','=','customer')->get();
        if(!isset($customers) and empty($customers)){
            $customers = [];
        }

        return view($this->folder."save",['type' => $type, 'record' => $record, 'title' => $this->title, 'customers' => $customers]);
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
            'title' => 'required',
            'description' => 'required',
            'content' => 'required'
        ]);

        $object = Message::findorfail($id);
        $object->title = $request->input('title');
        $object->description = $request->input('description');
        $object->content = $request->input('content');

        if($request->hasFile('cover')){
            $object->cover = $request->cover->store("messages/covers");
        }

        if($object->save()){
            flash("Registro Actualizado con Exito!!")->success();
        }else{
            flash("Error al Actualizar el Regisro!!")->error();
        }

        return redirect()->route('messages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $object = Message::findorfail($id);
        Storage::delete($object->cover);
        if($object->delete()){
            flash("Registro eliminado con Exito!!")->success();
        }else{
            flash("Error al tratar de eliminar el Registro!!")->error();
        }

        return redirect()->route('messages.index');
    }
}
