<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Accounts;

class accountsController extends Controller {
    public function index()
    {
        abort_unless(\Gate::allows('accounts_access'), 403);

        $accounts = Accounts::all();

        return view('admin.accounts.index', compact('accounts'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('accounts_create'), 403);

        return view('admin.accounts.create');
    }

    public function store(StoreProductRequest $request)
    {
        abort_unless(\Gate::allows('accounts_create'), 403);

        $product = Product::create($request->all());

        return redirect()->route('admin.accounts.index');
    }

    public function edit(Product $product)
    {
        abort_unless(\Gate::allows('accounts_edit'), 403);

        return view('admin.accounts.edit', compact('product'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        abort_unless(\Gate::allows('accounts_edit'), 403);

        $product->update($request->all());

        return redirect()->route('admin.accounts.index');
    }

    public function show(Product $product)
    {
        abort_unless(\Gate::allows('accounts_show'), 403);

        return view('admin.accounts.show', compact('product'));
    }

    public function destroy(Product $product)
    {
        abort_unless(\Gate::allows('accounts_delete'), 403);

        $product->delete();

        return back();
    }

    public function massDestroy(MassDestroyProductRequest $request)
    {
        Product::whereIn('id', request('ids'))->delete();

        return response(null, 204);
    }
}
