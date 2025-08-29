<?php

namespace App\Http\Controllers;

use App\Models\CustomerAlamat;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CustomerAlamatController extends Controller
{

    use AuthorizesRequests;
    public function index()
    {
        $customerAlamat = CustomerAlamat::with('customer')->whereHas('customer', function ($query) {
            $query->whereHas('bisnes', function ($q) {
                $q->where('user_id', auth()->id());
            });
        })->paginate(10);

        return view('customer-alamat.index', compact('customerAlamat'));
    }

    public function create()
    {
        $customer = Customer::whereHas('bisnes', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();

        return view('customer-alamat.create', compact('customer'));
    }

    public function show(CustomerAlamat $customer_alamat)
    {
        return view('customer-alamat.show', ['customerAlamat' => $customer_alamat]);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'customer_id' => 'required|exists:customer,id',
                'nama_penerima' => 'required|string|max:255',
                'alamat' => 'required|string|max:1000',
                'bandar' => 'required|string|max:100',
                'negeri' => 'required|string|max:100',
                'poskod' => 'required|string|min:4|max:6|regex:/^[0-9]+$/',
                'no_tel' => 'required|string|min:9|max:20|regex:/^[0-9\-\+\s\(\)]+$/',
            ], [
                'customer_id.required' => 'Sila pilih customer.',
                'customer_id.exists' => 'Customer yang dipilih tidak sah.',
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

            CustomerAlamat::create($validatedData);

            return redirect()->route('customer-alamat.index')->with('message', 'Alamat berjaya dicipta.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ralat berlaku: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(CustomerAlamat $customer_alamat)
    {
        $this->authorize('update', $customer_alamat);
        $customer = Customer::whereHas('bisnes', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();

        return view('customer-alamat.edit', ['customerAlamat' => $customer_alamat, 'customer' => $customer]);
    }

    public function update(Request $request, CustomerAlamat $customer_alamat)
    {
        try {
            $this->authorize('update', $customer_alamat);

            $validatedData = $request->validate([
                'customer_id' => 'required|exists:customer,id',
                'nama_penerima' => 'required|string|max:255',
                'alamat' => 'required|string|max:1000',
                'bandar' => 'required|string|max:100',
                'negeri' => 'required|string|max:100',
                'poskod' => 'required|string|min:4|max:6|regex:/^[0-9]+$/',
                'no_tel' => 'required|string|min:9|max:20|regex:/^[0-9\-\+\s\(\)]+$/',
            ], [
                'customer_id.required' => 'Sila pilih customer.',
                'customer_id.exists' => 'Customer yang dipilih tidak sah.',
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

            $customer_alamat->update($validatedData);

            return redirect()->route('customer-alamat.index')->with('message', 'Alamat berjaya dikemaskini.');
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back()->with('error', 'Anda tidak mempunyai kebenaran untuk mengemaskini alamat ini.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ralat berlaku: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(CustomerAlamat $customer_alamat)
    {
        $this->authorize('delete', $customer_alamat);
        $customer_alamat->delete();

        return redirect()->route('customer-alamat.index')->with('message', 'Alamat berjaya dipadamkan.');
    }
}
