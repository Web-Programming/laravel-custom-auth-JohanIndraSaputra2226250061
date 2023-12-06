<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prodis = Prodi::all();
        return $this->sendResponse($prodis, "Data Prodi");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validasi = $request->validate([
            'nama' => 'required|min:5|max:20',
            'foto' => 'required|file|image|max:5000'
        ]);

        $ext = $request->foto->getClientOriginalExtension();
        $nama_file = "foto-" . time() . "." . $ext;
        $path = $request->foto->storeAs('public', $nama_file);

        $prodi = new Prodi();
        $prodi->nama = $validasi['nama'];
        $prodi->foto = $nama_file;

        if($prodi->save()){
            $success['data'] = $prodi;
            return $this->sendResponse($success, 'Data prodi berhasil disimpan.');
        } else {
            return $this->sendError('Error.', ['error' => 'Data prodi gagal disimpan.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validasi = $request->validate([
            'nama' => 'required|min:5|max:20',
            'foto' => 'required|file|image|max:5000'
        ]);

        $ext = $request->foto->getClientOriginalExtension();
        $nama_file = "foto-" . time() . "." . $ext;
        $path = $request->foto->storeAs('public', $nama_file);

        $prodi = Prodi::find($id);
        $prodi->nama = $validasi['nama'];
        $prodi->foto = $nama_file;

        if($prodi->save()){
            $success['data'] = $prodi;
            return $this->sendResponse($success, 'Data Prodi berhasil diperbarui.');
        } else {
            return $this->sendError('Error.', ['error' => 'Data prodi gagal diperbarui.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function delete($id){
        $prodi = Prodi::findOrFail($id);
        if($prodi->delete()){
            $success['data'] = [];
            return $this->sendResponse($success, "Data prodi dengan id $id berhasil dihapus");
        } else {
            return $this->sendError('Error', ['error' => 'Data prodi gagal dihapus']);
        }
    }
}
