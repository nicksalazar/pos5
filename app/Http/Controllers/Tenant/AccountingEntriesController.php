<?php
namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Models\Tenant\Company;
use App\Models\Tenant\Configuration;
use App\CoreFacturalo\Helpers\Storage\StorageDocument;
use App\CoreFacturalo\Requests\Inputs\Common\EstablishmentInput;
use App\CoreFacturalo\Requests\Inputs\Common\PersonInput;
use App\Models\Tenant\TypesAccountingEntries;
use App\Http\Controllers\SearchItemController;
use App\Http\Requests\Tenant\AccountEntriesRequest;
use App\Http\Requests\Tenant\QuotationRequest;
use App\Http\Resources\Tenant\AccountingEntriesCollection;
use App\Http\Resources\Tenant\QuotationCollection;
use App\Http\Resources\Tenant\QuotationResource;
use App\Models\Tenant\Catalogs\DocumentType;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Item;
use App\Models\Tenant\AccountingEntries;
use App\Models\Tenant\AccountMovement;
use App\Models\Tenant\PaymentMethodType;
use App\Models\Tenant\Person;
use App\Models\Tenant\Quotation;
use App\Models\Tenant\Series;
use App\Models\Tenant\StateType;
use App\Models\Tenant\User;
use App\Models\Tenant\Warehouse;
use App\Traits\OfflineTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Modules\Finance\Traits\FinanceTrait;


class AccountingEntriesController extends Controller
{
    use FinanceTrait;
    use OfflineTrait;
    use StorageDocument;

    protected $quotation;
    protected $company;

    public function index()
    {
        $company = Company::select('soap_type_id')->first();
        $soap_company = $company->soap_type_id;
        $generate_order_note_from_quotation = Configuration::getRecordIndividualColumn('generate_order_note_from_quotation');
        return view('tenant.accounting-entries.index', compact('soap_company', 'generate_order_note_from_quotation'));
        
    }
    
    public function create()
    {
        return view('tenant.accounting-entries.form');
    }

    public function edit($id)
    {
        $resourceId = $id;
        return view('tenant.quotations.form_edit', compact('resourceId'));
    }

    public function columns()
    {
        return [
            'user_id' => 'Cliente',
            //'date_of_issue' => 'Fecha de emisión',
            //'delivery_date' => 'Fecha de entrega',
            //'user_name' => 'Registrado por',
            //'seller_name' => 'Vendedor',
            //'referential_information' => 'Inf.Referencial',
            //'number' => 'Número',
        ];
    }

   /* public function filter()
    {
        $state_types = StateType::whereIn('id', ['01', '05', '09'])->get();

        return compact('state_types');
    }*/

    public function records(Request $request)
    {
        $records = $this->getRecords($request);
        //dd($request->all());
        //dd($records);

        //return $records->paginate(config('tenant.items_per_page'));
        return new AccountingEntriesCollection($records->paginate(config('tenant.items_per_page')));
    }

    private function getRecords($request)
    {
        $column = $request->input('column');
        $value = $request->input('value');
        $query = AccountingEntries::query();

       /* if ($column === 'user_name') {
            $query->whereHas('user', function ($q) use ($value) {
                $q->where('name', 'like', "%{$value}%");
            })
                ->whereTypeUser();
        } else if ($column === 'customer') {
            $query->whereHas('person', function ($q) use ($value) {
                $q->where('name', 'like', "%{$value}%")
                    ->orWhere('number', 'like', "%{$value}%");
            })
                ->whereTypeUser();

        } else if ($column === 'seller_name') {
            $query->whereHas('seller', function ($q) use ($value) {
                $q->where('name', 'like', "%{$value}%");
            });

        } else if ($column === 'number') {
            if (!is_null($value) && $value !== '') {
                $query->where('id', $value);
            }
        } else {
            $query->where($column, 'like', "%{$value}%")
                ->whereTypeUser();
        }*/

    
        $records = $query->select('seat_general','comment','user_id','seat_date','types_accounting_entrie_id')
        ->with(['user'=> function ($query) {
            $query->select('id','name');
        }])
        ->with(['type_account'=> function ($query) {
            $query->select('id','name');
        }])
        ->with('detalles')
        ->distinct();
    
    
        $form = json_decode($request->form);
        //dd($records);

        /*if ($form->date_start && $form->date_end) {
            $records = $records->whereBetween('date_of_issue', [$form->date_start, $form->date_end]);
        }*/

        return $records;
    }

    public function searchCustomers(Request $request)
    {

        $customers = Person::whereType('customers')
            ->orderBy('name')
            ->whereIsEnabled();
        if ($request->has('customer_id')) {
            $customers->where('id', $request->customer_id);
        } else {
            $customers->where('number', 'like', "%{$request->input}%")
                ->orWhere('name', 'like', "%{$request->input}%");
        }
        $customers = $customers->get()->transform(function ($row) {
            /** @var Person $row */
            return $row->getCollectionData();
            /* Se ha movido al modelo */
            return [
                'id' => $row->id,
                'description' => $row->number . ' - ' . $row->name,
                'name' => $row->name,
                'number' => $row->number,
                'identity_document_type_id' => $row->identity_document_type_id,
                'identity_document_type_code' => $row->identity_document_type->code,
                'addresses' => $row->addresses,
                'address' => $row->address,
            ];
        });
        return compact('customers');
    }


    public function tables()
    {
        $idauth=auth()->user()->id;
        //$idauth=2;
        $lista=AccountingEntries::where('user_id','=',$idauth)->latest('id')->first();
        
        if(empty($lista)){
            $seat=1;
            $seat_general=1;
            
        }else{
            $genSeat=AccountingEntries::select('seat_general')->latest('id')->first();
            $seat=$lista->seat+1;
            $seat_general=$genSeat->seat_general+1;
        }
        
        $user=[
            'id'=>auth()->user()->id,
            'seat'=>$seat,
            'seat_general'=>$seat_general,
        ];
        $customers = $this->table('customers');
        $suppliers = $this->table('suppliers');
        $types_seat = TypesAccountingEntries::select('id','name')->get();
        return compact('user','types_seat','customers','suppliers');

    }



    public function item_tables()
    {
        $account_movement=AccountMovement::with('account_group')->get();
        return compact(
            'account_movement'
        );
    }

    public function record($id)
    {
        $record = new QuotationResource(Quotation::findOrFail($id));

        return $record;
    }

    public function record2($id)
    {
        $record = new QuotationResource(Quotation::findOrFail($id));

        return $record;
    }


    public function getFullDescription($row)
    {

        $desc = ($row->internal_id) ? $row->internal_id . ' - ' . $row->description : $row->description;
        $category = ($row->category) ? " - {$row->category->name}" : "";
        $brand = ($row->brand) ? " - {$row->brand->name}" : "";

        $desc = "{$desc} {$category} {$brand}";

        return $desc;
    }

    public function store(AccountEntriesRequest $request)
    {
        $idauth=auth()->user()->id;
        $lista=AccountingEntries::where('user_id','=',$idauth)->latest('id')->first();
        $ultimo=AccountingEntries::latest('id')->first();
        //$request->validated();
        if(empty($lista)){
            $seat=1;
            
        }else{
            
            $seat=$lista->seat+1;
        }

        if(empty($ultimo)){
            $seat_general=1;
            
        }else{
            $seat_general=$ultimo->seat_general+1;
        }

        foreach ($request['items'] as $row) {
            $row['seat']=$seat;
            $row['seat_general']=$seat_general;
            AccountingEntries::create($row);

        }

        return [
            'success' => true,
            'data' => [
                
                $seat
            ],
        ];
        /*DB::connection('tenant')->transaction(function () use ($request) {

            $data = $this->mergeData($request);
            $data['terms_condition'] = $this->getTermsCondition();

            $this->quotation = Quotation::create($data);

            foreach ($data['items'] as $row) {
                $this->quotation->items()->create($row);
            }

            $this->savePayments($this->quotation, $data['payments']);

            
            $this->createPdf($this->quotation, "a4", $this->quotation->filename);

        });

        return [
            'success' => true,
            'data' => [
                'id' => $this->quotation->id,
                'number_full' => $this->quotation->number_full,
            ],
        ];*/
    }

    public function update(QuotationRequest $request)
    {

        DB::connection('tenant')->transaction(function () use ($request) {
            // $data = $this->mergeData($request);
            // return $request['id'];
            $configuration = Configuration::select('terms_condition')->first();
            $request['terms_condition'] = $this->getTermsCondition();

            $this->quotation = Quotation::firstOrNew(['id' => $request['id']]);
            $this->quotation->fill($request->all());
            $this->quotation->customer = PersonInput::set($request['customer_id'], isset($request['customer_address_id']) ? $request['customer_address_id'] : null);
            $this->quotation->items()->delete();

            $this->deleteAllPayments($this->quotation->payments);

            foreach ($request['items'] as $row) {

                $this->quotation->items()->create($row);
            }

            $this->savePayments($this->quotation, $request['payments']);

            
        });

        return [
            'success' => true,
            'data' => [
                'id' => $this->quotation->id,
            ],
        ];

    }

    public function getTermsCondition()
    {

        $configuration = Configuration::select('terms_condition')->first();

        if ($configuration) {
            return $configuration->terms_condition;
        }

        return null;

    }


    


    public function mergeData($inputs)
    {

        $this->company = Company::active();

        $values = [
            'user_id' => auth()->id(),
            'external_id' => Str::uuid()->toString(),
            'customer' => PersonInput::set($inputs['customer_id'], isset($inputs['customer_address_id']) ? $inputs['customer_address_id'] : null),
            'establishment' => EstablishmentInput::set($inputs['establishment_id']),
            'soap_type_id' => $this->company->soap_type_id,
            'state_type_id' => '01'
        ];

        $inputs->merge($values);

        return $inputs->all();
    }



    public function table($table)
    {
        switch ($table) {
            case 'customers':

                $customers = Person::whereType('customers')->whereIsEnabled()->orderBy('name')->take(20)->get()->transform(function ($row) {
                    /** @var Person $row */
                    return $row->getCollectionData();
                    /** Se ha movido al modelo */
                    return [
                        'id' => $row->id,
                        'description' => $row->number . ' - ' . $row->name,
                        'name' => $row->name,
                        'number' => $row->number,
                        'identity_document_type_id' => $row->identity_document_type_id,
                        'identity_document_type_code' => $row->identity_document_type->code,
                        'addresses' => $row->addresses,
                        'address' => $row->address
                    ];
                });
                return $customers;

                break;

                case 'suppliers':

                    $suppliers = Person::whereType('suppliers')->orderBy('name')->get()->transform(function ($row) {
                        return [
                            'id' => $row->id,
                            'description' => $row->number . ' - ' . $row->name,
                            'name' => $row->name,
                            'number' => $row->number,
                            'perception_agent' => (bool)$row->perception_agent,
                            'identity_document_type_id' => $row->identity_document_type_id,
                            'identity_document_type_code' => $row->identity_document_type->code
                        ];
                    });
                    return $suppliers;

                    break;

            case 'items':

                $warehouse = Warehouse::where('establishment_id', auth()->user()->establishment_id)->first();

                $items = Item::orderBy('description')->whereIsActive()
                    // ->with(['warehouses' => function($query) use($warehouse){
                    //     return $query->where('warehouse_id', $warehouse->id);
                    // }])
                    ->take(20)->get();

                $this->ReturnItem($items);

                return $items;

                break;
            default:
                return [];

                break;
        }
    }


    /**
     * Realiza la busqueda de producto en cotizacion.
     * @param Request $request
     * @return array
     */
    public function searchItems(Request $request)
    {
        $items = SearchItemController::getItemsToQuotation($request);
        return compact('items');

    }


    public function searchItemById($id)
    {

        $items = SearchItemController::getItemsToQuotation(null, $id);
        return compact('items');

    }


    public function searchCustomerById($id)
    {
        return $this->searchClientById($id);

    }

 

    public function changed($id)
    {
        $record = Quotation::find($id);
        $record->changed = true;
        $record->save();

        return [
            'success' => true
        ];
    }

    public function updateStateType($state_type_id, $id)
    {
        $record = Quotation::find($id);
        $record->state_type_id = $state_type_id;
        $record->save();

        return [
            'success' => true,
            'message' => 'Estado actualizado correctamente'
        ];
    }


}
