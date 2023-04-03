<template>
    <el-dialog :close-on-click-modal="false"
               :title="titleDialog"
               :visible="showDialog"
               :append-to-body="true"
               @close="close"
               @open="create"
               @opened="opened">
        <form autocomplete="off"
              @submit.prevent="submit">
            <div class="form-body">
                <el-tabs v-model="activeName">
                    <el-tab-pane class
                                 name="first">
                        <span slot="label">{{ titleTabDialog }}</span>
                        <div class="row">

                            <div class="col-md-6">
                                <div :class="{'has-danger': errors.idMethodType}"
                                     class="form-group">
                                    <label class="control-label">Tipo</label>
                                    <el-select v-model="form.idMethodType"
                                               dusk="tipoTransporte"
                                               filterable>
                                        <el-option v-for="option in methodTypes"
                                                   :key="option.id"
                                                   :label="option.description"
                                                   :value="option.description"></el-option>
                                    </el-select>
                                    <small v-if="errors.idMethodType"
                                           class="form-control-feedback"
                                           v-text="errors.idMethodType[0]"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div :class="{'has-danger': errors.idCliente}"
                                     class="form-group">
                                    <label class="control-label">Cliente</label>
                                    <el-select v-model="form.idCliente"
                                               dusk="tipoTransporte"
                                               filterable>
                                        <el-option v-for="option in clients"
                                                   :key="option.id"
                                                   :label="option.description"
                                                   :value="option.description"></el-option>
                                    </el-select>
                                    <small v-if="errors.idCliente"
                                           class="form-control-feedback"
                                           v-text="errors.idCliente[0]"></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Valor</label>
                                <el-input-number v-model="form.valor" :step="1" :min="0"></el-input-number>
                                <small v-if="errors.valor"
                                            class="form-control-feedback"
                                            v-text="errors.valor[0]"></small>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Nota</label>
                                <el-input v-model="form.observation"></el-input>
                                <small v-if="errors.observation"
                                            class="form-control-feedback"
                                            v-text="errors.observation[0]"></small>
                            </div>
                        </div>

                    </el-tab-pane>
                </el-tabs>
            </div>
            <div class="form-actions text-right mt-4">
                <el-button @click.prevent="close()">Cancelar</el-button>
                <el-button :loading="loading_submit"
                           native-type="submit"
                           type="primary">{{ typeDialog }}
                </el-button>
            </div>
        </form>
    </el-dialog>
</template>

<script>
import {mapActions, mapState} from "vuex/dist/vuex.mjs";
import {serviceNumber} from '@mixins/functions'

export default {
    mixins: [serviceNumber],
    props: [
        'showDialog',
        'recordId',
        'external',
        'document_type_id',
        'input_person',
        'parentId',
    ],
    data() {
        return {
            clients:[],
            methodTypes:[],
            loading_submit: false,
            titleDialog: null,
            titleTabDialog: null,
            typeDialog: null,
            resource: 'finances/advances',
            errors: {},
            form: {
            },

        }
    },
    async created() {

        this.loadConfiguration()
        await this.initForm()


    },
    computed: {
        ...mapState([
            'config',
            'person',
            'parentPerson',
        ]),
        maxLength: function () {
            if (this.form.identity_document_type_id === '6') {
                return 11
            }
            if (this.form.identity_document_type_id === '1') {
                return 8
            }
        },
        created(){
            this.$http.get(`/finances/advances/tables`)
                    .then(response => {
                        console.log('DATA CREATED: ', response.data.data)
                        this.clients = response.data.data.clients
                    }).then(() => {
                    //this.updateEmail()
                })
        },
    },
    methods: {
        ...mapActions([
            'loadConfiguration',
        ]),
        initForm() {
            this.errors = {}
            this.form = {
                id: null,
                estado:'Registrada',
                fechaLlegada: null,
                fechaEmbarque: null,
                tipoTransporte: null,
                numeroImportacion:null,

            }
            this.resource = 'finances/advances'

        },
        async opened() {

        },
        create() {

            this.titleDialog = (this.recordId) ? 'Editar anticipo' : 'Nuevo anticipo';
            this.titleTabDialog = 'Datod el anticipo';
            this.typeDialog = (this.recordId) ? 'Editar' : 'Guardar';
            this.isEditForm = (this.recordId) ? true : false;
            if (this.recordId) {
                this.$http.get(`/${this.resource}/record/${this.recordId}`)
                    .then(response => {
                        console.log('DATOS A EDITAR: ', response.data.data)
                        this.form = response.data.data
                    }).then(() => {
                    //this.updateEmail()
                })
            }
        },
        async submit() {
            this.loading_submit = true

            await this.$http.post(`/${this.resource}`, this.form)
                .then(response => {
                    if (response.data.success) {
                        this.$message.success(response.data.message)
                        if (this.external) {
                            this.$eventHub.$emit('reloadDataPersons', response.data.id)
                        } else {
                            this.$eventHub.$emit('reloadData')
                        }
                        this.close()
                    } else {
                        this.$message.error(response.data.message)
                    }

                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data
                    } else {
                        console.log(error)
                    }
                })
                .finally(() => {
                    this.loading_submit = false
                })
        },
        close() {
            this.$eventHub.$emit('initInputPerson')
            this.$emit('update:showDialog', false)
            this.initForm()
        },
    }
}
</script>
