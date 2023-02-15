<?php
namespace App\Http\Controllers\Tenant;

use App\Http\Requests\Tenant\AccountGroupRequest;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Http\Resources\Tenant\AccountGroupCollection;
use App\Models\Tenant\AccountGroup;

class AccountGroupController extends Controller
{
    public function index()
    {
       
        return view('tenant.account-groups.index');
        
    }
    public function columns()
    {
        return [
            'code' => 'Código Cuenta',
            'description' => 'Descripción',
            'type' => 'Tipo',
        ];
    }

    public function records(Request $request)
    {
        $records = AccountGroup::where($request->column, 'like', "%{$request->value}%")
                            ->latest();
        return new AccountGroupCollection($records->paginate(config('tenant.items_per_page')));
    }


    public function record($id)
    {
        $record = AccountGroup::findOrFail($id);

        return $record;
    }

    public function store(AccountGroupRequest $request)
    {
        $id = $request->input('id');
        $person_type = AccountGroup::firstOrNew(['id' => $id]);
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
            
            $person_type = AccountGroup::findOrFail($id);
            $person_type_type = 'Cuenta Grupos';
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
