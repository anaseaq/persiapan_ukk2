<?php

namespace App\Http\Controllers;
use App\Models\Barangmasuk;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangmasukController extends Controller
{
    public function index(Request $request)
    {
        $rsetBarangmasuk = Barangmasuk::with('barang')->latest()->paginate(10);

        return view('barangmasuk.index', compact('rsetBarangmasuk'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $abarang = Barang::all();
        return view('barangmasuk.create',compact('abarang'));
    }

    public function store(Request $request)
    {
        //return $request;
        //validate form
        $this->validate($request, [
            'tgl_masuk'    => 'required',
            'qty_masuk'    => 'required',
            'barang_id'     => 'required|not_in:blank',
        ]);

        //create post
        Barangmasuk::create([
            'tgl_masuk'    => $request->tgl_masuk,
            'qty_masuk'    => $request->qty_masuk,
            'barang_id'     => $request->barang_id
        ]);

        //redirect to index
        return redirect()->route('barangmasuk.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rsetBarangmasuk = Barangmasuk::find($id);

        //return $rsetBarang;

        //return view
        return view('barangmasuk.show', compact('rsetBarangmasuk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    $abarang = Barang::all();
    $rsetBarangmasuk = Barangmasuk::find($id);
    $selectedBarang = Barang::find($rsetBarangmasuk->barang_id);

    return view('barangmasuk.edit', compact('rsetBarangmasuk', 'abarang', 'selectedBarang'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'tgl_masuk'    => 'required',
            'qty_masuk'    => 'required',
            'barang_id'     => 'required|not_in:blank',
        ]);

        $rsetBarangmasuk = Barangmasuk::find($id);

        $rsetBarangmasuk->update([
            'tgl_masuk'    => $request->tgl_masuk,
            'qty_masuk'    => $request->qty_masuk,
            'barang_id'     => $request->barang_id
        ]);

        // Redirect to the index page with a success message
        return redirect()->route('barangmasuk.index')->with(['success' => 'Data Berhasil Diubah!']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rsetBarangmasuk = Barangmasuk::find($id);

        //delete post
        $rsetBarangmasuk->delete();

        //redirect to index
        return redirect()->route('barangmasuk.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
