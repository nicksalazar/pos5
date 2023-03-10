<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tenant\ImportResource;
use App\Http\Resources\Tenant\ImportsCollection;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Imports;
use Illuminate\Http\Request;

class ImportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $configuration = Configuration::getPublicConfig();

        return view('tenant.imports.index',
        compact('configuration'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->type == 'integrator')
            return redirect('/imports');

        $configuration = Configuration::first();

        return view('tenant.imports.form', compact( 'configuration'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $id = $request->input('id');
        $import = Imports::firstOrNew(['id' => $id]);
        $data = $request->all();
        unset($data['id']);

        $import->fill($data);
        $import->save();

        $msg = '';

        $msg = ($id) ? 'Importacion editada con éxito' : 'Importacion registrada con éxito';

        return [
            'success' => true,
            'message' => $msg,
            'id' => $import->id
        ];
    }

    public function record($id)
    {
        $record = new ImportResource(Imports::findOrFail($id));

        return $record;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tenant\Imports  $imports
     * @return \Illuminate\Http\Response
     */
    public function show(Imports $imports)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tenant\Imports  $imports
     * @return \Illuminate\Http\Response
     */
    public function edit(Imports $imports)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tenant\Imports  $imports
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Imports $imports)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tenant\Imports  $imports
     * @return \Illuminate\Http\Response
     */
    public function destroy(Imports $imports)
    {
        //
    }

    public function getRecords($request)
    {
        $d_llegada = $request->d_llegada;
        $d_embarque = $request->d_embarque;

        $date_of_issue = $request->date_of_issue;

        $number= $request->document_type_id;
        $tipoTransporte = $request->tipoTransporte;

        $estado = $request->estado;

        $fechaEmbarque = $request->fechaEmbarque;

        $fechaLlegada = $request->fechaLlegada;

        $records = Imports::query();

        if ($d_embarque && $d_llegada) {
            $records->whereBetween('date_of_issue', [$d_embarque, $d_llegada]);
        }
        if ($date_of_issue) {
            $records->where('date_of_issue', 'like', '%' . $date_of_issue . '%');
        }
        if ($fechaEmbarque) {
            $records->where('fechaEmbarque', 'like', '%' . $fechaEmbarque . '%');
        }
        if ($fechaLlegada) {
            $records->where('fechaLlegada', 'like', '%' . $fechaLlegada . '%');
        }
        if ($number) {
            $records->where('numeroImportacion', 'like', '%' . $number. '%');
        }
        if ($estado) {
            $records->where('estado', 'like', '%' . $estado . '%');
        }
        if ($tipoTransporte) {
            $records->where('tipoTransporte', 'like', '%' . $tipoTransporte . '%');
        }

        return $records;
    }

    public function records(Request $request)
    {

        $records = $this->getRecords($request);

        return new ImportsCollection($records->paginate(config('tenant.items_per_page')));
    }
}
