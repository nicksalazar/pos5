<template>
    <div>
        <div class="page-header pr-0">
            <h2><a href="/dashboard"><i class="fas fa-tachometer-alt"></i></a></h2>
            <ol class="breadcrumbs">
                <li class="active"><span>Asientos Contables</span></li>
            </ol>
            <div class="right-wrapper pull-right">
                <a :href="`/${resource}/create`" class="btn btn-custom btn-sm  mt-2 mr-2"><i
                    class="fa fa-plus-circle"></i> Nuevo</a>
            </div>
        </div>
        <div class="card mb-0">
            <div class="card-header bg-info py-1">
                <h4 class="my-0">Búsqueda</h4>
            </div>
            <div class="">
                <data-table :resource="resource">
                    <div slot="heading">
                    </div>
                    <div slot-scope="{ index, row }" :class="{ anulate_color : row.state_type_id == '11' }">

                          <div class="card mb-0 mt-3">
                            <div class="card-body">
                                <div class="text-right">
                            <button type="button" data-toggle="tooltip" data-placement="top" title="Editar" class="btn waves-effect waves-light btn-xs btn-info" @click.prevent="clickCreate(row.id)"><i class="fa fa-edit"></i></button>
                            <button type="button" data-toggle="tooltip" data-placement="top" title="Generar PDF" class="btn waves-effect waves-light btn-xs btn-warning" @click.prevent="clickCreate(row.id)"><i class="fa fa-file-pdf"></i></button>
                             <template v-if="typeUser === 'admin'">
                             <button type="button" data-toggle="tooltip" data-placement="top" title="Eliminar"  class="btn waves-effect waves-light btn-xs btn-danger" @click.prevent="clickDelete(row.id)"><i class="fa fa-trash"></i></button>
                             </template>
                        </div>

                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr class="table-active">
                                            <th  colspan="2" class="font-weight-bold text-center">Cuenta</th>
                                            <th width="13%" class="font-weight-bold text-center">Debe</th>
                                            <th width="13%" class="font-weight-bold text-center">Haber</th>
                                            <th width="15%" class="font-weight-bold text-center">Centro de Costo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <tr>
                                            <td colspan="2" class="text-center py-0">
                                                <p class="my-0" >-- {{ row.seat_date | toDate }} --</p>
                                                <p class="my-0">{{row.seat_general}} </p>
                                            </td>
                                            <td  class="text-center"></td>
                                            <td  class="text-center"></td>
                                            <td  class="text-center"></td>
                                            </tr>

                                            <tr>
                                           <td colspan="2" >
                                                <p class="my-0" >
                                                Prueba
                                                </p>
                                            </td>
                                            <td  class="text-center">$ 440.00</td>
                                            <td  class="text-center">$ 0.00</td>
                                            <td  class="text-center"></td>
                                            </tr>
                                            
                                            <tr>
                                           <td colspan="2" >
                                                <p class="ml-5 my-0" >
                                                Prueba2
                                                </p>
                                            </td>
                                            <td  class="text-center">$ 0.00</td>
                                            <td  class="text-center">$ 440.00</td>
                                            <td  class="text-center"></td>
                                            </tr>
                                            
                                          <tr>
                                            <td>
                                                <p class="my-0" >
                                                <b>Glosa:</b>
                                                {{row.comment}}
                                                </p>
                                            </td>
                                            <td width="7%" class="font-weight-bold">
                                                
                                                <p class="my-0" >TOTAL: </p>
                                            </td>
                                            <td  class="text-center">$ 440.00</td>
                                            <td  class="text-center">$ 440.00</td>
                                            <td  class="text-center"></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                 </div>
                            </div>
                            </div>

                        
             

                    </div>
                </data-table>
            </div>
  
        </div>
    </div>
</template>
<style scoped>
.anulate_color {
    color: red;
}
</style>
<script>

import DataTable from '../../../components/DataTableAccountEntries.vue'
import {deletable} from '../../../mixins/deletable'
import {mapActions, mapState} from "vuex";
export default {
    props: [
        'typeUser',
        'soapCompany',
        'generateOrderNoteFromQuotation',
    ],
    mixins: [
        deletable
    ],
    components: {
        DataTable
    },
    computed: {
        ...mapState([
            'config',
        ]),

    },
    data() {
        return {
            resource: 'accounting-entries',
            recordId: null,
            showDialogPayments: false,
            showDialogOptions: false,
            showDialogOptionsPdf: false,
            state_types: [],
            columns: {
                total_exportation: {
                    title: 'T.Exportación',
                    visible: false
                },
                total_unaffected: {
                    title: 'T.Inafecto',
                    visible: false
                },
                total_exonerated: {
                    title: 'T.Exonerado',
                    visible: false
                },
                total_free: {
                    title: 'T.Gratuito',
                    visible: false
                },
                contract: {
                    title: 'Contrato',
                    visible: false
                },
                delivery_date: {
                    title: 'T.Entrega',
                    visible: false
                },
                referential_information: {
                    title: 'Inf.Referencial',
                    visible: false,
                },
                order_note: {
                    title: 'Pedidos',
                    visible: false,
                },
                exchange_rate_sale: {
                    title: 'Tipo de cambio',
                    visible: false
                },
            }
        }
    },
    async created() {
        
    },
    mounted() {
        this.loadConfiguration()
    },
    methods: {
        ...mapActions([
            'loadConfiguration',
        ]),
        canMakeOrderNote(row) {

            let permission = true

            // Si ya tiene Pedidos, no se genera uno nuevo
            if (row.order_note.full_number) {
                permission = false
            } else {
                if (this.typeUser !== 'admin') {
                    permission = this.generateOrderNoteFromQuotation
                }
            }

            return permission
        },
        clickPrintContract(external_id) {
            window.open(`/contracts/print/${external_id}/a4`, '_blank');
        },
        clickPayment(recordId) {
            this.recordId = recordId;
            this.showDialogPayments = true;
        },
        async changeStateType(row) {

            await this.updateStateType(`/${this.resource}/state-type/${row.state_type_id}/${row.id}`).then(() =>
                this.$eventHub.$emit('reloadData')
            )

        },

        clickEdit(id) {
            this.recordId = id
            this.showDialogFormEdit = true
        },
        clickOptions(recordId = null) {
            this.recordId = recordId
            this.showDialogOptions = true
        },
        clickOptionsPdf(recordId = null) {
            this.recordId = recordId
            this.showDialogOptionsPdf = true
        },
        clickAnulate(id) {
            this.anular(`/${this.resource}/anular/${id}`).then(() =>
                this.$eventHub.$emit('reloadData')
            )
        },
        makeOrder(quotation) {
            let tos = parseInt(quotation);
            localStorage.setItem('Quotation', tos)
            localStorage.setItem('FromQuotation', true)
            window.location.href = "/order-notes/create";
        },
        duplicate(id) {
            this.$http.post(`${this.resource}/duplicate`, {id})
                .then(response => {
                    if (response.data.success) {
                        this.$message.success('Se guardaron los cambios correctamente.')
                        this.$eventHub.$emit('reloadData')
                    } else {
                        this.$message.error('No se guardaron los cambios')
                    }
                })
                .catch(error => {

                })
            this.$eventHub.$emit('reloadData')
        },
        clickGenerateDocument(recordId) {
            window.location.href = `/documents/create/quotations/${recordId}`;
        }
    }
}
</script>
