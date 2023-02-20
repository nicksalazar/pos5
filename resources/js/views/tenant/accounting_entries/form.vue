<template>
    <div class="card mb-0 pt-2 pt-md-0">
                <div class="page-header pr-0">
            <h2><a href="/dashboard"><i class="fas fa-tachometer-alt"></i></a></h2>
            <ol class="breadcrumbs">
                <li class="active"><span>Crear Asiento Contable</span></li>
            </ol>
        </div>
        <div class="tab-content" v-if="loading_form">
            <div class="invoice">
                <form autocomplete="off" @submit.prevent="submit">
                    <div class="form-body">

                        <div class="row mt-1">
                             <div class="col-lg-6">
                                <div class="form-group row" :class="{'has-danger': errors.seat_date}">
                                    <label class="col-sm-4 col-form-label font-weight-bold text-info">Fecha:</label>
                                     <div class="col-sm-6">
                                    <el-date-picker v-model="form.seat_date" type="date" value-format="yyyy-MM-dd" :clearable="false"></el-date-picker>
                                     </div>
                                    <small class="form-control-feedback" v-if="errors.seat_date" v-text="errors.seat_date[0]"></small>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-1">
                             <div class="col-lg-6">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label font-weight-bold text-info">Comentarios:</label>
                                     <div class="col-sm-8">
                                      <el-input v-model="form.comment"></el-input>
                                        <small class="form-control-feedback" v-if="errors.comment" v-text="errors.comment[0]"></small>
                                     </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-1">
                             <div class="col-lg-6">
                                <div class="form-group row" :class="{'has-danger': errors.date_of_issue}">
                                    <label class="col-sm-4 col-form-label font-weight-bold text-info">Tipo Asiento:</label>
                                     <div class="col-sm-8">
                                       <el-select v-model="form.types_accounting_entries_id">
                                        <el-option v-for="option in types_seat" :key="option.id" :value="option.id" :label="option.name"></el-option>
                                    </el-select>
                                    <small class="form-control-feedback" v-if="errors.types_accounting_entries_id" v-text="errors.types_accounting_entries_id[0]"></small>
                                     </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-1">
                             <div class="col-lg-6">
                                <div class="form-group row">
                                    <div class="col-sm-4">
                                    <el-select v-model="form.is_client">
                                        <el-option v-for="option in tipo_cliente" :key="option.id" :value="option.id" :label="option.name"></el-option>
                                    </el-select>
                                    </div>
                                     <div class="col-sm-8">
                                    <el-input v-model="form.third_code"></el-input>
                                     </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th width="5%">#</th>
                                                <th class="font-weight-bold"width="30%">Cuenta</th>
                                                <th width="15%" class="text-center font-weight-bold">Debe</th>
                                                <th width="15%" class="text-center font-weight-bold">Haber</th>
                                                <th class="text-center font-weight-bold">Centro costo</th>
                                                <th class="text-center font-weight-bold"></th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="form.items.length > 0">
                                            <tr v-for="(row, index) in form.items" :key="index">
                                                <td>{{index + 1}}</td>
                                                <td>{{  (row.cuenta)}}</td>
                                                <td class="text-center">
                                                    <input class="form-control text-right" type="number" min="0" step=".01" v-model="row.debe" @change="calculateTotal()" />
                                                    </td>
                                                <td class="text-center">
                                                    <input class="form-control text-right" type="number" min="0" step=".01" v-model="row.haber" @change="calculateTotal()" >
                                                </td>
                                                <td class="text-center">
                                                     <input class="form-control" type="text"  v-model="row.seat_cost" />
                                                    </td>
                                                <td class="series-table-actions text-center">
                                                    <div v-if="index>1">

                                                <button  type="button" class="btn waves-effect waves-light btn-xs btn-danger"  @click.prevent="clickRemoveItem(index)">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                    </div>
                                            </td>
                                            </tr>
                                            <tr>
                                                <td ></td>
                                                <td ></td>
                                                <td class="border-top border-dark"> <input class="form-control text-right" readonly type="number" min="0" step=".01" v-model="total_debe" /></td>
                                                <td class="border-top border-dark"> <input class="form-control text-right" readonly type="number" min="0" step=".01" v-model="total_haber" /></td>
                                                <td ></td>
                                                <td ></td>
                                                
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-6 d-flex align-items-end">
                                <div class="form-group">
                                    <button type="button" class="btn waves-effect waves-light btn-primary" @click="addNewRow">+ Agregar Detalle</button>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="form-actions text-right mt-4">
                        <el-button @click.prevent="close()">Cancelar</el-button>
                        <el-button class="submit" type="primary" native-type="submit" :loading="loading_submit" v-if="form.items.length > 0">Generar</el-button>
                    </div>
                </form>
            </div>
        </div>

        <quotation-form-item :showDialog.sync="showDialogAddItem"
                           :currency-type-id-active="form.currency_type_id"
                           :exchange-rate-sale="form.exchange_rate_sale"
                             :typeUser="typeUser"
                             :recordItem="recordItem"
                             :configuration="config"
                             :customer-id="form.customer_id"
                             :percentage-igv="percentage_igv"
                             :currency-types="currency_types"
                             :show-option-change-currency="true"
                           @add="addRow"></quotation-form-item>
    </div>
</template>

<script>
    import QuotationFormItem from './partials/item.vue'
    import {functions, exchangeRate} from '../../../mixins/functions'
    import {showNamePdfOfDescription} from '../../../helpers/functions'
    import {mapActions, mapState} from "vuex/dist/vuex.mjs";

    export default {
        props:[
            'typeUser',
            'configuration',
        ],
        components: {QuotationFormItem},
        mixins: [functions, exchangeRate],
        data() {
            return {
                input_person: {},
                resource: 'accounting-entries',
                showDialogAddItem: false,
                showDialogOptions: false,
                loading_submit: false,
                loading_form: false,
                errors: {},
                form: {},
                currency_types: [],
                tipo_cliente: [
                    {id:0,'name':'Cliente'},
                    {id:1,'name':'Proveedor'},
                    
                ],
                types_seat:[],
                establishments: [],
                establishment: null,
                currency_type: {},
                quotationNewId: null,
                activePanel: 0,
                loading_search:false,
                recordItem: null,
                total_discount_no_base: 0,
                total_haber: 0,
                total_debe: 0,
            }
        },
        async created() {
            this.loadConfiguration()
            this.$store.commit('setConfiguration', this.configuration)
            await this.initForm()
            await this.$http.get(`/${this.resource}/tables`)
                .then(response => {
                    const data = response.data
                    this.currency_types = data.currency_types
                    this.types_seat = data.types_seat
                    this.establishments = data.establishments
                    this.form.currency_type_id = (this.currency_types.length > 0)?this.currency_types[0].id:null
                    this.form.establishment_id = (this.establishments.length > 0)?this.establishments[0].id:null
                })
            await this.getPercentageIgv();
            this.loading_form = true

        },
        computed: {
            ...mapState([
                'config',
            ]),
        },
        methods: {
            ...mapActions([
                'loadConfiguration',
            ]),
            clickAddItem() {
                this.recordItem = null;
                this.showDialogAddItem = true;
            },
            ediItem(row, index) {
                row.indexi = index
                this.recordItem = row
                this.showDialogAddItem = true
            },

            clickCancel(index) {
                this.form.payments.splice(index, 1);
            },

            getFormatUnitPriceRow(unit_price){
                return _.round(unit_price, 6)
            },

            initForm() {
                this.errors = {}
                this.form = {
                    description: '',
                    establishment_id: null,
                    seat_date: moment().format('YYYY-MM-DD'),
                    date_of_issue: moment().format('YYYY-MM-DD'),
                    time_of_issue: moment().format('HH:mm:ss'),
                    customer_id: null,
                    currency_type_id:0, 
                    types_accounting_entries_id:null, 
                    third_code:null,
                    is_client:0,
                    exchange_rate_sale: 0,
                    total_prepayment: 0,
                    total_discount: 0,
                    total_exportation: 0,
                    total_free: 0,
                    total_taxed: 0,
                    total_unaffected: 0,
                    total_exonerated: 0,
                    total_igv: 0,
                    total_igv_free: 0,
                    total_taxes: 0,
                    total_value: 0,
                    total: 0,
                    subtotal: 0,
                    items: [
                        {'id':1,'cuenta':2,'debe':3,'haber':4,'seat_cost':5},
                        {'id':1,'cuenta':2,'debe':3,'haber':4,'seat_cost':5},
                        {'id':1,'cuenta':2,'debe':3,'haber':4,'seat_cost':5}
                    ],
                    discounts: [],
                    comment:null,
                    payments: [],
                }


                this.total_discount_no_base = 0

            },
            resetForm() {
                this.activePanel = 0
                this.initForm()
                this.form.currency_type_id = (this.currency_types.length > 0)?this.currency_types[0].id:null
                this.form.establishment_id = (this.establishments.length > 0)?this.establishments[0].id:null

            },

            addRow(row) {
                if (this.recordItem) {
                    this.form.items[this.recordItem.indexi] = row
                    this.recordItem = null
                } else {
                    this.form.items.push(JSON.parse(JSON.stringify(row)));
                }

                this.calculateTotal();
            },

              addNewRow() {
           this.form.items.push( {'id':1,'cuenta':2,'debe':3,'haber':4,'seat_cost':5});
           this.calculateTotal();
        },
            clickRemoveItem(index) {
                this.form.items.splice(index, 1)
                this.calculateTotal()
            },
            calculateTotal() {

                let total_discount = 0
                let total_exportation = 0
                let total_taxed = 0
                let total_exonerated = 0
                let total_unaffected = 0
                let total_free = 0
                let total_igv = 0
                let total_value = 0
                let total = 0
                let total_debe = 0
                let total_haber = 0
                let total_igv_free = 0
                this.total_discount_no_base = 0

                this.form.items.forEach((row) => {
                    total_debe += parseFloat(row.debe)
                    total_haber += parseFloat(row.haber)

                });

                this.form.total_igv_free = _.round(total_igv_free, 2)
                this.form.total_discount = _.round(total_discount, 2)
                this.form.total_exportation = _.round(total_exportation, 2)
                this.form.total_taxed = _.round(total_taxed, 2)
                this.form.total_exonerated = _.round(total_exonerated, 2)
                this.form.total_unaffected = _.round(total_unaffected, 2)
                this.form.total_free = _.round(total_free, 2)
                this.form.total_igv = _.round(total_igv, 2)
                this.form.total_value = _.round(total_value, 2)
                this.form.total_taxes = _.round(total_igv, 2)
                this.form.subtotal = _.round(total, 2)
                this.total_debe = _.round(total_debe, 2)
                this.total_haber = _.round(total_haber, 2)

            },
            validate_payments(){

                //eliminando items de pagos
                for (let index = 0; index < this.form.payments.length; index++) {
                    if(parseFloat(this.form.payments[index].payment) === 0)
                        this.form.payments.splice(index, 1)
                }

                let error_by_item = 0
                let acum_total = 0

                this.form.payments.forEach((item)=>{
                    acum_total += parseFloat(item.payment)
                    if(item.payment <= 0 || item.payment == null) error_by_item++;
                })

                return  {
                    error_by_item : error_by_item,
                    acum_total : acum_total
                }

            },
 
            async submit() {

                let validate = await this.validate_payments()
                if(validate.acum_total > parseFloat(this.form.total) || validate.error_by_item > 0) {
                    return this.$message.error('Los montos ingresados superan al monto a pagar o son incorrectos');
                }

                this.loading_submit = true

                await this.$http.post(`/${this.resource}`, this.form).then(response => {
                    if (response.data.success) {

                        this.resetForm();
                        this.quotationNewId = response.data.data.id;
                        this.saveCashDocument(this.quotationNewId)

                    }
                    else {
                        this.$message.error(response.data.message);
                    }
                }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data;
                    }
                    else {
                        this.$message.error(error.response.data.message);
                    }
                }).then(() => {
                    this.loading_submit = false;
                });
            },
            close() {
                location.href = '/quotations'
            },

            setDescriptionOfItem(item){
                return showNamePdfOfDescription(item,this.config.show_pdf_name)
            },
            async saveCashDocument(id){
                await this.$http.post(`/cash/cash_document`, {
                        quotation_id: id,
                    })
                    .then(response => {
                        if (response.data.success) {
                        } else {
                            this.$message.error(response.data.message);
                        }
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            keyupCustomer() {

                if (this.input_person.number) {

                    if (!isNaN(parseInt(this.input_person.number))) {

                        switch (this.input_person.number.length) {
                            case 8:
                                this.input_person.identity_document_type_id = '1'
                                
                                break;

                            case 11:
                                this.input_person.identity_document_type_id = '6'
                                
                                break;
                            default:
                                this.input_person.identity_document_type_id = '6'
                                
                                break;
                        }
                    }
                }
            },
        }
    }
</script>
