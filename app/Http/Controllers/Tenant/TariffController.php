<?php

namespace App\Http\Controllers\Tenant;

use App\Models\Tenant\Tariff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Tenant\TariffCollection;
use App\Http\Resources\Tenant\TariffResource;
use App\Models\Tenant\Configuration;

class TariffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $configuration = Configuration::getPublicConfig();
        return view('tenant.imports.tariff',
        compact('configuration'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
        $tariff = Tariff::firstOrNew(['id' => $id]);
        $data = $request->all();
        unset($data['id']);

        $tariff->fill($data);
        $tariff->save();

        $msg = '';
        $msg = ($id) ? 'Arancel editado con éxito' : 'Arancel registrado con éxito';

        return [
            'success' => true,
            'message' => $msg,
            'id' => $tariff->id
        ];
    }

    public function record($id)
    {
        $record = new TariffResource(Tariff::findOrFail($id));
        return $record;
    }

    public function records(Request $request)
    {

        $records = $this->getRecords($request);

        return new TariffCollection($records->paginate(config('tenant.items_per_page')));
    }

    private function getRecords($request)
    {
        $d_llegada = $request->d_llegada;
        $d_embarque = $request->d_embarque;

        $date_of_issue = $request->date_of_issue;

        $number= $request->document_type_id;
        $tipoTransporte = $request->tipoTransporte;

        $estado = $request->estado;

        $fechaEmbarque = $request->fechaEmbarque;

        $fechaLlegada = $request->fechaLlegada;

        $records = Tariff::query();

        if ($date_of_issue) {
            $records->where('created_at', 'like', '%' . $date_of_issue . '%');
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tenant\Tariff  $tariff
     * @return \Illuminate\Http\Response
     */
    public function show(Tariff $tariff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tenant\Tariff  $tariff
     * @return \Illuminate\Http\Response
     */
    public function edit(Tariff $tariff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tenant\Tariff  $tariff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tariff $tariff)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tenant\Tariff  $tariff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tariff $tariff)
    {
        //
    }
}
