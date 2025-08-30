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
        $this->authorize('view', $customer);
        return view('customer.show', compact('customer'));
    }

    public function create(Request $request)
    {
        $data = $request->output ?? null;
        // $response = json_decode(session('response'));
        // $response;
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

        dd($request->all());

        if ($request->no_tel)
            $request->whatsapp_id = "6" . str_replace(" ", "", $request->no_tel) . "@c.us";
        $request->create_by_ai = false;
        $customer = Customer::create($request->all());

        return redirect()->route('customer.index')->with('success', 'Customer created successfully.');
    }

    public function edit(Customer $customer)
    {
        $this->authorize('update', $customer);
        $bisnes = Bisnes::where('user_id', auth()->id())->get();
        return view('customer.edit', compact('customer', 'bisnes'));
    }

    public function update(Request $request, Customer $customer)
    {
        $this->authorize('update', $customer);

        $request->validate([
            'no_tel' => 'required|string|max:20',
            'gelaran' => 'required|string|max:50',
            'bisnes_id' => 'required|exists:bisnes,id',
        ]);

        $customer->update($request->all());

        return redirect()->route('customer.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        $this->authorize('delete', $customer);
        $customer->delete();

        return redirect()->route('customer.index')->with('success', 'Customer deleted successfully.');
    }
}
