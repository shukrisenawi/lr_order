<?php

namespace App\Http\Controllers;

use App\Models\ProspekAlamat;
use App\Models\Prospek;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProspekAlamatController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $prospekAlamat = ProspekAlamat::with('prospek')->whereHas('prospek', function ($query) {
            $query->whereHas('bisnes', function ($q) {
                $q->where('user_id', auth()->id());
            });
        })->paginate(10);

        return view('prospek-alamat.index', compact('prospekAlamat'));
    }

    public function create()
    {
        $prospek = Prospek::whereHas('bisnes', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();

        return view('prospek-alamat.create', compact('prospek'));
    }

    public function show(ProspekAlamat $prospek_alamat)
    {
        return view('prospek-alamat.show', ['prospekAlamat' => $prospek_alamat]);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'prospek_id' => 'required|exists:prospek,id',
                'nama_penerima' => 'required|string|max:255',
                'alamat' => 'required|string|max:1000',
                'bandar' => 'required|string|max:100',
                'negeri' => 'required|string|max:100',
                'poskod' => 'required|string|min:4|max:6|regex:/^[0-9]+$/',
                'no_tel' => 'required|string|min:9|max:20|regex:/^[0-9\-\+\s\(\)]+$/',
            ], [
                'prospek_id.required' => 'Sila pilih prospek.',
                'prospek_id.exists' => 'Prospek yang dipilih tidak sah.',
                'nama_penerima.required' => 'Nama penerima diperlukan.',
                'alamat.required' => 'Alamat diperlukan.',
                'bandar.required' => 'Bandar diperlukan.',
                'negeri.required' => 'Negeri diperlukan.',
                'poskod.required' => 'Poskod diperlukan.',
                'poskod.min' => 'Poskod mesti sekurang-kurangnya 4 digit.',
                'poskod.max' => 'Poskod tidak boleh melebihi 6 digit.',
                'poskod.regex' => 'Poskod hanya boleh mengandungi nombor.',
                'no_tel.required' => 'No telefon diperlukan.',
                'no_tel.min' => 'No telefon mesti sekurang-kurangnya 9 digit.',
                'no_tel.max' => 'No telefon tidak boleh melebihi 20 digit.',
                'no_tel.regex' => 'Format no telefon tidak sah.',
            ]);

            // Set active to true by default if not provided
            $validatedData['active'] = $request->has('active') ? (bool)$request->active : true;

            ProspekAlamat::create($validatedData);

            return redirect()->route('prospek-alamat.index')->with('message', 'Alamat berjaya dicipta.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ralat berlaku: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(ProspekAlamat $prospek_alamat)
    {
        $this->authorize('update', $prospek_alamat);
        $prospek = Prospek::whereHas('bisnes', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();

        return view('prospek-alamat.edit', ['prospekAlamat' => $prospek_alamat, 'prospek' => $prospek]);
    }

    public function update(Request $request, ProspekAlamat $prospek_alamat)
    {
        try {
            $this->authorize('update', $prospek_alamat);

            $validatedData = $request->validate([
                'prospek_id' => 'required|exists:prospek,id',
                'nama_penerima' => 'required|string|max:255',
                'alamat' => 'required|string|max:1000',
                'bandar' => 'required|string|max:100',
                'negeri' => 'required|string|max:100',
                'poskod' => 'required|string|min:4|max:6|regex:/^[0-9]+$/',
                'no_tel' => 'required|string|min:9|max:20|regex:/^[0-9\-\+\s\(\)]+$/',
            ], [
                'prospek_id.required' => 'Sila pilih prospek.',
                'prospek_id.exists' => 'Prospek yang dipilih tidak sah.',
                'nama_penerima.required' => 'Nama penerima diperlukan.',
                'alamat.required' => 'Alamat diperlukan.',
                'bandar.required' => 'Bandar diperlukan.',
                'negeri.required' => 'Negeri diperlukan.',
                'poskod.required' => 'Poskod diperlukan.',
                'poskod.min' => 'Poskod mesti sekurang-kurangnya 4 digit.',
                'poskod.max' => 'Poskod tidak boleh melebihi 6 digit.',
                'poskod.regex' => 'Poskod hanya boleh mengandungi nombor.',
                'no_tel.required' => 'No telefon diperlukan.',
                'no_tel.min' => 'No telefon mesti sekurang-kurangnya 9 digit.',
                'no_tel.max' => 'No telefon tidak boleh melebihi 20 digit.',
                'no_tel.regex' => 'Format no telefon tidak sah.',
            ]);

            // Set active to true by default if not provided
            $validatedData['active'] = $request->has('active') ? (bool)$request->active : true;

            $prospek_alamat->update($validatedData);

            return redirect()->route('prospek-alamat.index')->with('message', 'Alamat berjaya dikemaskini.');
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back()->with('error', 'Anda tidak mempunyai kebenaran untuk mengemaskini alamat ini.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ralat berlaku: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(ProspekAlamat $prospek_alamat)
    {
        $this->authorize('delete', $prospek_alamat);
        $prospek_alamat->delete();

        return redirect()->route('prospek-alamat.index')->with('message', 'Alamat berjaya dipadamkan.');
    }
}
