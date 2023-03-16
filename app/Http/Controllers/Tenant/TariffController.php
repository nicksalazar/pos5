<?php

namespace App\Http\Controllers\Tenant;

use App\Models\Tenant\Tariff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\TariffRequest;
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
    public function store(TariffRequest $request)
    {
        $id = $request->input('id');
        $tariff = Tariff::firstOrNew(['id' => $id]);
        $data = $request->all();
        unset($data['id']);

        $tariff->fill($data);
        $tariff->save();

        $msg = '';
        $msg = ($id) ? 'Partida Arancelaria editada con éxito' : 'Partida Arancelaria registrada con éxito';

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

        $tariff = $request->tariff;

        $active= $request->active;

        $records = Tariff::query();

        if ($tariff) {
            $records->where('tariff', 'like', '%' . $tariff . '%');
        }

        if ($active) {
            if($active > 1){
                $records->where('active', 'like', '%' . 0 . '%');
            }else{
                $records->where('active', 'like', '%' . 1 . '%');
            }

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
