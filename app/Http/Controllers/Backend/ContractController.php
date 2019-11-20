<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Contract;


class ContractController extends Controller
{
    public function index()
    {
        return view('backend.contract.index', ['contracts' => Contract::all()]);
    }

    public function create()
    {
        return view('backend.contract.create', ['contract' => new Contract]);
    }

    public function store(Request $request, Contract $contract)
    {
        $contract = $contract->create($request->all());

        return redirect()->route('admin.contract.index')->with('success', 'Contract created');
    }

    public function show(Contract $contract)
    {
        return redirect()->route('admin.contract.index');
    }

    public function edit(Contract $contract)
    {
        return view('backend.contract.edit', ['contract' => $contract]);
    }

    public function update(Request $request, Contract $contract)
    {

        $contract->update($request->all());

        return redirect()->route('admin.contract.edit', ['contract' => $contract->id])->with('success', 'Contract updated');
    }

    public function destroy(Contract $contract)
    {
        $contract->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }
}
