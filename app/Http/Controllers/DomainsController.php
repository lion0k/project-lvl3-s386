<?php

namespace App\Http\Controllers;

use App\Domain;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DomainsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        $domains = DB::table('domains')->paginate(5);
        return view('domain.index', ['domains' => $domains]);
    }

    public function show($id)
    {
        $domain = Domain::findOrFail($id);
        return view('domain.show', ['domain' => $domain]);
    }

    public function store(Request $request)
    {
        $rules = ['name' => 'required|active_url'];

        $this->validate($request, $rules);

        $domain = new Domain();
        $domain->name = $request->name;
        $domain->save();
        $id = $domain->id;
        return redirect()->route('domains.show', ['id' => $id]);
    }
}
