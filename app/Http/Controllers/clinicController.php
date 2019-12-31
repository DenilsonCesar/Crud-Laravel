<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\clinic;

class clinicController extends Controller
{
    public function index(){
        return clinic::all();
    }

    public function store(Request $request){

        // Handle File Upload
        if($request->hasFile('foto')){
            // Get filename with the extension
            $filenameWithExt = $request->file('foto')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('foto')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('foto')->storeAs('public/fotos', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }
        // Create Post
        $clinica = new clinic;

        $clinica->clinic = $request->clinic;
        $clinica->fone = $request->fone;
        $clinica->endereco = $request->endereco;
        $clinica->cidade = $request->cidade;
        $clinica->bairro = $request->bairro;
        $clinica->foto = $fileNameToStore;
        $clinica->save();
    }

    public function show($id){
        return clinic::findOrFail($id);
    }

    public function update(Request $request ,$id){

        $Clinic = clinic::findOrFail($id);
        // Handle File Upload
        if($request->hasFile('foto')){
           // Get filename with the extension
           $filenameWithExt = $request->file('foto')->getClientOriginalName();
           // Get just filename
           $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
           // Get just ext
           $extension = $request->file('foto')->getClientOriginalExtension();
           // Filename to store
           $fileNameToStore= $filename.'_'.time().'.'.$extension;
           // Upload Image
           $path = $request->file('foto')->storeAs('public/fotos', $fileNameToStore);
           // Delete file if exists
           Storage::delete('public/fotos/'.$Clinic->foto);
        }
        // Update Clinic

        $Clinic->clinic = $request->clinic;
        $Clinic->fone = $request->fone;
        $Clinic->endereco = $request->endereco;
        $Clinic->cidade = $request->cidade;
        $Clinic->bairro = $request->bairro;

        if($request->hasFile('foto')){
            $Clinic->foto = $fileNameToStore;
        }
        $Clinic->save();

    }

    public function destroy($id){
        $Clinic = clinic::findOrFail($id);
        $Clinic->delete();
    }
}
