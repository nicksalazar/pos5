<template>
    <div>
        <div class="page-header pr-0">
            <h2><a href="/dashboard"><i class="fas fa-tachometer-alt"></i></a></h2>
            <ol class="breadcrumbs">
                <li class="active"><span>Importaciones</span></li>
                <li><span class="text-muted">P. Arancelarias</span>
                </li>
            </ol>
            <div class="right-wrapper pull-right"
                 v-if="typeUser != 'integrator'">
                 <button class="btn btn-custom btn-sm  mt-2 mr-2" type="button" @click.prevent="clickCreate()"><i
                    class="fa fa-plus-circle"></i> Nuevo
                </button>
            </div>
        </div>
        <div class="card mb-0">

            <div class="card-body ">
                <data-table :resource="resource">

                    <tr slot="heading">

                        <th>#</th>
                        <th class="text-center" style="min-width: 95px;">P. Arancelaria</th>
                        <th class="text-center" style="min-width: 95px;">ADVALOREN</th>
                        <th class="text-center" style="min-width: 95px;">Tarifa Especifica</th>
                        <th class="text-center" style="min-width: 95px;">FODINFA</th>
                        <th class="text-center" style="min-width: 95px;">Estado</th>
                        <th class="text-center"></th>

                    </tr>
                    <tr slot-scope="{ index, row }"
                        :class="{'text-success': (row.active === true),
                            'text-warning': (row.active === false)}">
                        <td>{{ index }}</td>
                        <td class="text-center" > {{ row.tariff }}</td>
                        <td class="text-center" > {{ row.advaloren }}</td>
                        <td class="text-center">{{ row.specific_tariff }}</td>
                        <td class="text-center">{{ row.fodinfa }}</td>
                        <td class="text-center" >
                            <span
                                  class="badge bg-secondary text-white"
                                  :class="{'bg-success': (row.active === true), 'bg-secondary': (row.active === false)}">
                                {{ row.active }}
                            </span>
                        </td>
                        <td class="text-right"
                        v-if="row.estado != 'Liquidada'" >
                            <div class="dropdown">
                                <button class="btn btn-default btn-sm" type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" >
                                    <div >
                                        <button class="dropdown-item"
                                                @click.prevent="clickCreate(row.id)">Editar
                                        </button>
                                    </div>

                                </div>
                            </div>

                        </td>
                    </tr>
                </data-table>
            </div>
            <tenant-imports-generate
                          :recordId="recordId"
                          :showDialog.sync="showDialog"
                          ></tenant-imports-generate>

        </div>
    </div>
</template>

<script>

import DataTable from '../../../components/DataTableTariffs.vue'
import {deletable} from '../../../mixins/deletable'
import {mapActions, mapState} from "vuex/dist/vuex.mjs";

export default {
    mixins: [deletable],
    props: [
        'configuration',

    ],
    computed: {
        ...mapState([
            'config',
        ]),
    },
    components: {

        DataTable,
    },
    data() {
        return {
            showDialog: false,
            resource: 'tariff',
            recordId: null,
            showDialogOptions: false,
            showDialogPayments: false,
            columns: {
            }
        }
    },
    created() {
        this.$store.commit('setConfiguration', this.configuration)
        this.loadConfiguration();
        //this.getColumnsToShow();

    },
    methods: {
        ...mapActions(['loadConfiguration']),
        clickCreate(recordId = null) {
            this.recordId = recordId
            this.showDialog = true
        },
        clickVoided(recordId = null) {
            this.recordId = recordId
            this.showDialogVoided = true
        },
        clickDownload(download) {
            window.open(download, '_blank');
        },
        clickResend(document_id) {
            this.$http.get(`/${this.resource}/send/${document_id}`)
                .then(response => {
                    if (response.data.success) {
                        this.$message.success(response.data.message)
                        this.$eventHub.$emit('reloadData')
                    } else {
                        this.$message.error(response.data.message)
                    }
                })
                .catch(error => {
                    this.$message.error(error.response.data.message)
                })
        },
        clickSendOnline(document_id) {
            this.$http.get(`/${this.resource}/send_server/${document_id}/1`).then(response => {
                if (response.data.success) {
                    this.$message.success('Se envio satisfactoriamente el comprobante.');
                    this.$eventHub.$emit('reloadData');

                    this.clickCheckOnline(document_id);
                } else {
                    this.$message.error(response.data.message);
                }
            }).catch(error => {
                this.$message.error(error.response.data.message)
            });
        },
        clickGenerteReport(importId){

            window.open(`/imports/liquidation-report/${importId}`, '_blank');
        },

        clickCheckOnline(document_id) {
            this.$http.get(`/${this.resource}/check_server/${document_id}`)
                .then(response => {
                    if (response.data.success) {
                        this.$message.success('Consulta satisfactoria.')
                        this.$eventHub.$emit('reloadData')
                    } else {
                        this.$message.error(response.data.message)
                    }
                })
                .catch(error => {
                    this.$message.error(error.response.data.message)
                })
        },
        clickCDetraction(recordId) {
            this.recordId = recordId
            this.showDialogCDetraction = true
        },
        clickOptions(recordId = null) {
            this.recordId = recordId
            this.showDialogOptions = true
        },
        clickReStore(document_id) {
            this.$http.get(`/${this.resource}/re_store/${document_id}`)
                .then(response => {
                    if (response.data.success) {
                        this.$message.success(response.data.message)
                        this.$eventHub.$emit('reloadData')
                    } else {
                        this.$message.error(response.data.message)
                    }
                })
                .catch(error => {
                    this.$message.error(error.response.data.message)
                })
        },
        tooltip(row, message = true) {
            if (message) {
                if (row.shipping_status) return row.shipping_status.message;

                if (row.sunat_shipping_status) return row.sunat_shipping_status.message;

                if (row.query_status) return row.query_status.message;
            }

            if ((row.shipping_status) || (row.sunat_shipping_status) || (row.query_status)) return true;

            return false;
        },
        clickPayment(recordId) {
            this.recordId = recordId;
            this.showDialogPayments = true;
        },
        clickChangeToRegisteredStatus(document_id) {
            this.$http.get(`/${this.resource}/change_to_registered_status/${document_id}`)
                .then(response => {
                    if (response.data.success) {
                        this.$message.success(response.data.message)
                        this.$eventHub.$emit('reloadData')
                    } else {
                        this.$message.error(response.data.message)
                    }
                })
                .catch(error => {
                    this.$message.error(error.response.data.message)
                })
        },
        clickImport() {
            this.showImportDialog = true
        },
        clickDownloadReportPagos() {
            this.showDialogReportPaymentComplete = true
        },
        clickImportSecond() {
            this.showImportSecondDialog = true
        },
        clickImportExcel() {
            this.showImportExcelDialog = true
        },
        clickDeleteDocument(document_id) {
            this.destroy(`/${this.resource}/delete_document/${document_id}`).then(() =>
                this.$eventHub.$emit('reloadData')
            )
        },
        clickReportPayments() {
            this.showDialogReportPayment = true
        },
        clickForceSendBySummary(id)
        {
            this.forceSendBySummary(`/${this.resource}/force-send-by-summary`, { id : id}).then(() =>
                this.$eventHub.$emit('reloadData')
            )
        },
        clickRetention(recordId) {
            this.recordId = recordId;
            this.showDialogRetention = true
        }
    }
}
</script>
