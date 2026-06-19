<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Requests\ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $clients = Client::with('contracts')
        ->latest()
        ->when($request->search, function ($q) use ($request) {
            $q->search($request->search);
        })
        ->paginate(10);

        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(ClientRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('identification_photo')) {
            $data['identification_photo'] =
                $request->file('identification_photo')->store('clients','public');
        }

        Client::create($data);

        return redirect()
            ->route('clients.index')
            ->with('success', 'تم إضافة العميل بنجاح');
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(ClientRequest $request, Client $client)
    {
        $data = $request->validated();

        if ($request->hasFile('identification_photo')) {

            if ($client->identification_photo) {
                Storage::delete($client->identification_photo);
            }

            $data['identification_photo'] =
                $request->file('identification_photo')->store('clients','public');
          
        }

        $client->update($data);

        return redirect()
            ->route('clients.index')
            ->with('success', 'تم تعديل العميل بنجاح');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return back()->with('success', 'Client deleted successfully');
    }

    // Restore deleted client
    public function restore($id)
    {
        Client::withTrashed()->findOrFail($id)->restore();

        return back()->with('success', 'Client restored successfully');
    }

    // Soft deleted list
    public function trashed()
    {
        $clients = Client::onlyTrashed()->paginate(10);

        return view('clients.trashed', compact('clients'));
    }
}