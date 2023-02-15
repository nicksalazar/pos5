<?php
namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\AccountMovementsRequest;
use Exception;
use Illuminate\Http\Request;
use App\Http\Resources\Tenant\AccountMovementsCollection;
use App\Models\Tenant\AccountMovement;

class AccountMovementController extends Controller
{
    public function index()
    {
       
        return view('tenant.account-movements.index');
        
    }
    public function columns()
    {
        return [
            'code' => 'Código Cuenta',
            'description' => 'Descripción',
            'cost_center' => 'Centro Costo',
            'type' => 'Tipo',
        ];
    }

    public function records(Request $request)
    {
        $records = AccountMovement::where($request->column, 'like', "%{$request->value}%")
                            ->latest();
        return new AccountMovementsCollection ($records->paginate(config('tenant.items_per_page')));
    }


    public function record($id)
    {
        $record = AccountMovement::findOrFail($id);

        return $record;
    }

    public function store(AccountMovementsRequest $request)
    {
        $id = $request->input('id');
        $person_type = AccountMovement::firstOrNew(['id' => $id]);
        $person_type->fill($request->all());
        $person_type->save();
  

        return [
            'success' => true,
            'message' => ($id)?'Cuenta editado con éxito':'Cuenta registrado con éxito',
        ];
    }

    public function destroy($id)
    {
        try {            
            
            $person_type = AccountMovement::findOrFail($id);
            $person_type_type = 'Cuenta Movimiento';
            $person_type->delete(); 

            return [
                'success' => true,
                'message' => $person_type_type.' eliminado con éxito'
            ];

        } catch (Exception $e) {

            return ($e->getCode() == '23000') ? ['success' => false,'message' => "El {$person_type_type} esta siendo usado por otros registros, no puede eliminar"] : ['success' => false,'message' => "Error inesperado, no se pudo eliminar el {$person_type_type}"];

        }
        
    }
  

}
