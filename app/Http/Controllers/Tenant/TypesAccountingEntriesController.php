<?php
namespace App\Http\Controllers\Tenant;

use App\Http\Requests\Tenant\TypesAccountingEntriesRequest;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Http\Resources\Tenant\TypesAccountingEntriesCollection;
use App\Models\Tenant\TypesAccountingEntries;

class TypesAccountingEntriesController extends Controller
{
    public function index()
    {
       
        return view('tenant.types_accounting_entries.index');
        
    }
    public function columns()
    {
        return [
            'name' => 'Nombre',
        ];
    }

    public function records(Request $request)
    {
        $records = TypesAccountingEntries::where($request->column, 'like', "%{$request->value}%")
                            ->latest();
        return new TypesAccountingEntriesCollection($records->paginate(config('tenant.items_per_page')));
    }


    public function record($id)
    {
        $record = TypesAccountingEntries::findOrFail($id);

        return $record;
    }

    public function store(TypesAccountingEntriesRequest $request)
    {
        $id = $request->input('id');
        $person_type = TypesAccountingEntries::firstOrNew(['id' => $id]);
        $person_type->fill($request->all());
        $person_type->save();
  

        return [
            'success' => true,
            'message' => ($id)?'Tipo de Asiento editado con éxito':' Tipo de Asiento registrado con éxito',
        ];
    }

    public function destroy($id)
    {
        try {            
            
            $person_type = TypesAccountingEntries::findOrFail($id);
            $person_type_type = 'Tipo de Asiento';
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
