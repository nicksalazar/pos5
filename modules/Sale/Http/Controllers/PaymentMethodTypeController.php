<?php

namespace Modules\Sale\Http\Controllers;

use App\Models\Tenant\AccountMovement;
use App\Models\Tenant\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Sale\Http\Resources\PaymentMethodTypeCollection;
use App\Models\Tenant\PaymentMethodType;
use App\Models\Tenant\SriFormasPagos;
use Exception;
use Modules\Sale\Http\Requests\PaymentMethodTypeRequest;

class PaymentMethodTypeController extends Controller
{

    public function records(Request $request)
    {
        $records = PaymentMethodType::get();

        return new PaymentMethodTypeCollection($records);
    }
    public function record($id)
    {
        //JOINSOFTWARE
        if ($id != 'join6v') {
            $record = PaymentMethodType::findOrFail($id);
            $sri = SriFormasPagos::get();
            $isCountable = Company::active();
            $record['pago_sri_list'] = $sri;
            $record['isCountable'] = (bool)  $isCountable->countable;
            $record['accounts'] = AccountMovement::get();
            return $record;
        } else {
            $sri = SriFormasPagos::get();
            $isCountable = Company::active();
            $record['pago_sri_list'] = $sri;
            $record['isCountable'] = (bool)  $isCountable->countable;
            $record['accounts'] = AccountMovement::get();
            return $record;
        }
    }

    public function store(PaymentMethodTypeRequest $request)
    {

        $id = $request->input('id');
        $record = PaymentMethodType::firstOrNew(['id' => $id]);
        $record->fill($request->all());
        $record->save();


        return [
            'success' => true,
            'message' => ($id)?'Método de pago editado con éxito':'Método de pago registrado con éxito',
        ];

    }

    public function destroy($id)
    {
        try {

            $record = PaymentMethodType::findOrFail($id);
            $record->delete();

            return [
                'success' => true,
                'message' => 'Método de pago eliminado con éxito'
            ];

        } catch (Exception $e) {

            return ($e->getCode() == '23000') ? ['success' => false,'message' => "El Método de pago esta siendo usado por otros registros, no puede eliminar"] : ['success' => false,'message' => "Error inesperado, no se pudo eliminar el Método de pago "];

        }

    }




}
