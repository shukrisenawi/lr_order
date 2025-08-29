<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Bisnes;
use App\Helpers\BisnesHelper;
use App\Events\NewDataEvent;
use Illuminate\Support\Facades\Http;
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
        $selectedBisnes = BisnesHelper::getSelectedBisnes();

        if (!$selectedBisnes) {
            return redirect()->route('bisnes.create')->with('info', 'Sila cipta bisnes terlebih dahulu.');
        }

        $bisnes = BisnesHelper::getUserBisnes();
        return view('customer.create', compact('bisnes', 'selectedBisnes'));
    }

    public function store(Request $request)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://n8n-mt8umikivytz.n8x.biz.id/webhook-test/6a5efb9d-d847-4dfc-8dbd-2cca3e8ebbf9', [
            'sessionId' => 'd8f86e9d3e0f403db4da6a5d98cfb1f7',
            'chatInput' => 'No 337 taman amalina lestari 27600 raub pahang\n017-9348252\nAzrini zameri',
            'action' => 'sendMessage',
        ]);

        if ($response->successful()) {
            dd($response);
        } else {
            dd($response);
        }
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
