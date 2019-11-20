<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Client;


class ClientController extends Controller
{
    public function index()
    {
        return view('backend.client.index', ['clients' => Client::all()]);
    }

    public function create()
    {
        return view('backend.client.create', ['client' => new Client]);
    }

    public function store(Request $request, Client $client)
    {
        $client = $client->create($request->all());

        return redirect()->route('admin.client.index')->with('success', 'Client created');
    }

    public function show(Client $client)
    {
        return redirect()->route('admin.client.index');
    }

    public function edit(Client $client)
    {
        return view('backend.client.edit', ['client' => $client]);
    }

    public function update(Request $request, Client $client)
    {

        $client->update($request->all());

        return redirect()->route('admin.client.edit', ['client' => $client->id])->with('success', 'Client updated');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }
}
