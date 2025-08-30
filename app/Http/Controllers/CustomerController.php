<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Bisnes;
use App\Helpers\BisnesHelper;
use App\Events\NewDataEvent;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function index()
    {
        $selectedBisnesId = BisnesHelper::getSelectedBisnesId();

        if (!$selectedBisnesId) {
            return redirect()->route('bisnes.create')->with('info', 'Sila cipta bisnes terlebih dahulu.');
        }

        $customer = Customer::with('bisnes')
            ->where('bisnes_id', $selectedBisnesId)
            ->paginate(10);

        return view('customer.index', compact('customer'));
    }

    public function show(Customer $customer)
    {
        return view('customer.show', compact('customer'));
    }

    public function create(Request $request)
    {
        $data = $request->output ?? null;
        return view('customer.create', compact('data'));
    }

    public function generate()
    {
        return view('customer.generate');
    }

    public function generateData(Request $request)
    {
        $request->validate(
            [
                'text_alamat' => 'required|string',
            ]
        );
        $response = $this->sendToN8n($request->text_alamat);

        if (isset($response['code']) && $response['code'] == 404) {
            return redirect()->route('customer.generate')->with('error', $response['message']);
        } else if (isset($response[0]['output']['alamat'])) {
            // dd(json_encode($response[0]));
            return redirect()->route('customer.create', $response[0])->with('success', 'Customer generate successfully.');
        } else {
            return redirect()->route('customer.generate')->with('error', 'Data gagal diproses. Sila semak data yang di masukkan.');
        }
    }

    public function sendToN8n($message)
    {
        $data = [
            'sessionId' => uniqid(),
            'action' => 'sendMessage',
            'chatInput' => $message
        ];
        $response = $this->sentN8n($data, true, 'https://n8n-mt8umikivytz.n8x.biz.id/webhook/6a5efb9d-d847-4dfc-8dbd-2cca3e8ebbf9', 'https://n8n-mt8umikivytz.n8x.biz.id/webhook-test/6a5efb9d-d847-4dfc-8dbd-2cca3e8ebbf9');

        return $response; // ambil respon JSON dari n8n
    }

    public function store(Request $request)
    {
        try {
            $request->merge(['bisnes_id' => session('selected_bisnes_id')]);
            $request->validate([
                'bisnes_id' => 'required|exists:bisnes,id',
                'whatsapp_id' => 'nullable|string|max:50',
                'gelaran' => 'nullable|string|max:50',
                'nama_penerima' => 'required|string|max:100',
                'alamat' => 'required|string',
                'poskod' => 'required|string|max:10',
                'no_tel' => 'required|string|max:50',
                'email' => 'nullable|string|max:100',
                'catatan' => 'nullable|string|max:200'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            dd($e->validator->errors()->all());
        }

        // Remove dd() to allow code execution
        $data = $request->all();

        if ($request->no_tel) {
            // Normalize phone number to format: 60195168839@c.us
            $no_tel = preg_replace('/[^0-9]/', '', $request->no_tel); // Remove non-digits
            if (strpos($no_tel, '601') === 0) {
                // Already starts with 601
                $normalized = $no_tel;
            } elseif (strpos($no_tel, '01') === 0) {
                // Malaysian mobile, replace leading 0 with 6
                $normalized = '6' . substr($no_tel, 1);
            } else {
                // Fallback: just add 6 in front
                $normalized = '6' . $no_tel;
            }
            $data['whatsapp_id'] = $normalized . "@c.us";
        }

        $dataContact = [
            'sessionId' => uniqid(),
            'bisnes_id' => session('selected_bisnes_id'),
            'nama' => $data['nama_penerima'],
            'no_tel' => $data['no_tel'],
            'alamat' => $data['alamat'],
        ];
        $response = $this->sentN8n($dataContact, true, 'https://n8n-mt8umikivytz.n8x.biz.id/webhook/cf1a7beb-3a83-4c6d-8302-748f5331a3d0', 'https://n8n-mt8umikivytz.n8x.biz.id/webhook-test/cf1a7beb-3a83-4c6d-8302-748f5331a3d0');
        dd($response);
        exit;
        if (Customer::create($data)) {
            $data = [
                'sessionId' => uniqid(),
                'bisnes_id' => session('selected_bisnes_id'),
                'nama' => $data['nama_penerima'],
                'no_tel' => $data['no_tel'],
                'alamat' => $data['alamat'],
            ];
            $response = $this->sentN8n($data, true, 'https://n8n-mt8umikivytz.n8x.biz.id/webhook/cf1a7beb-3a83-4c6d-8302-748f5331a3d0', 'https://n8n-mt8umikivytz.n8x.biz.id/webhook-test/cf1a7beb-3a83-4c6d-8302-748f5331a3d0');
        }

        return redirect()->route('customer.index')->with('success', 'Customer created successfully.');
    }

    public function edit(Customer $customer)
    {
        return view('customer.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        try {

            $request->validate([
                'whatsapp_id' => 'nullable|string|max:50',
                'gelaran' => 'nullable|string|max:50',
                'nama_penerima' => 'required|string|max:100',
                'alamat' => 'required|string',
                'poskod' => 'required|string|max:10',
                'no_tel' => 'required|string|max:50',
                'email' => 'nullable|string|max:100',
                'catatan' => 'nullable|string|max:200'
            ]);

            $customer->update($request->all());

            return redirect()->route('customer.index')->with('success', 'Customer updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            dd($e->validator->errors()->all());
        }
    }

    public function destroy(Customer $customer)
    {
        $this->authorize('delete', $customer);
        $customer->delete();

        return redirect()->route('customer.index')->with('success', 'Customer deleted successfully.');
    }
}
