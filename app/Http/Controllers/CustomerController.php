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

    public function create()
    {
        echo session('response');
        exit;
        // $response = json_decode(session('response'));
        // $response;
        return view('customer.create');
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
        $response = json_encode($this->sendToN8n($request->text_alamat));
        return redirect()->route('customer.create', $response)->with('response', $response)->with('success', 'Customer generate successfully.');
    }

    public function sendToN8n($message)
    {
        $data = [
            'action' => 'sendMessage',
            'chatInput' => $message
        ];
        $response = $this->sentN8n('https://n8n-mt8umikivytz.n8x.biz.id/webhook-test/6a5efb9d-d847-4dfc-8dbd-2cca3e8ebbf9', 'https://n8n-mt8umikivytz.n8x.biz.id/webhook/6a5efb9d-d847-4dfc-8dbd-2cca3e8ebbf9', $data);

        return $response; // ambil respon JSON dari n8n
    }

    public function store(Request $request)
    {
        dd($this->sendToN8n());
        // $request->validate([
        //     'text_alamat' => 'required|string|max:20',
        //     'gelaran' => 'required|string|max:50',
        //     'bisnes_id' => 'required|exists:bisnes,id',
        // ]);

        // $customer = Customer::create($request->all());

        // // Broadcast new data event
        // broadcast(new NewDataEvent('customer', [
        //     'id' => $customer->id,
        //     'message' => 'Customer baru telah didaftarkan',
        //     'gelaran' => $customer->gelaran,
        //     'no_tel' => $customer->no_tel
        // ], auth()->id(), $request->bisnes_id));

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
