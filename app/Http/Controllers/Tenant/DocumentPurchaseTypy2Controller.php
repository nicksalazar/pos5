<?php

namespace App\Http\Controllers\Tenant;

use App\Models\Tenant\PurchaseDocumentTypes2;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Tenant\PurchaseDocumentTypeCollection;
use App\Http\Resources\Tenant\PurchaseDocumentTypeResource;
use App\Models\Tenant\Configuration;

class DocumentPurchaseTypy2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $configuration = Configuration::getPublicConfig();
        return view('tenant.purchases.document_types',
        compact('configuration'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tenant\PurchaseDocumentTypes2  $purchaseDocumentTypes2
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseDocumentTypes2 $purchaseDocumentTypes2)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tenant\PurchaseDocumentTypes2  $purchaseDocumentTypes2
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseDocumentTypes2 $purchaseDocumentTypes2)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tenant\PurchaseDocumentTypes2  $purchaseDocumentTypes2
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseDocumentTypes2 $purchaseDocumentTypes2)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tenant\PurchaseDocumentTypes2  $purchaseDocumentTypes2
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseDocumentTypes2 $purchaseDocumentTypes2)
    {
        //
    }

    public function record($id)
    {
        $record = new PurchaseDocumentTypeResource(PurchaseDocumentTypes2::findOrFail($id));
        return $record;
    }

    public function records(Request $request)
    {

        $records = $this->getRecords($request);

        return new PurchaseDocumentTypeCollection($records->paginate(config('tenant.items_per_page')));
    }

    private function getRecords($request)
    {

        $tariff = $request->tariff;

        $active= $request->active;

        $records = PurchaseDocumentTypes2::query();

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
}
