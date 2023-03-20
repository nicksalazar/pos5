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
                            <div class="col-md-4">
                                <div :class="{'has-danger': errors.tariff}"
                                     class="form-group">
                                    <label class="control-label">P. Arancelaria <span class="text-danger">*</span></label>
                                    <el-input v-model="form.tariff"
                                                :disabled="isEditForm"
                                                dusk="name"></el-input>
                                    <small v-if="errors.tariff"
                                           class="form-control-feedback"
                                           v-text="errors.tariff[0]"></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div :class="{'has-danger': errors.description}"
                                     class="form-group">
                                    <label class="control-label">Descripción</label>
                                    <el-input v-model="form.description"
                                                dusk="name"></el-input>
                                    <small v-if="errors.description"
                                           class="form-control-feedback"
                                           v-text="errors.description[0]"></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div :class="{'has-danger': errors.advaloren}"
                                     class="form-group">
                                    <label class="control-label">ADVALOREM</label>
                                    <el-input-number v-model="form.advaloren"
                                                :max="100"
                                                :step="0.5"
                                                dusk="name"></el-input-number>
                                    <small v-if="errors.advaloren"
                                           class="form-control-feedback"
                                           v-text="errors.advaloren[0]"></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div :class="{'has-danger': errors.specific_tariff}"
                                     class="form-group">
                                    <label class="control-label">Tarifa especifica</label>
                                    <el-input-number v-model="form.specific_tariff"
                                                :max="100"
                                                dusk="name"></el-input-number>
                                    <small v-if="errors.specific_tariff"
                                           class="form-control-feedback"
                                           v-text="errors.specific_tariff[0]"></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div :class="{'has-danger': errors.fodinfa}"
                                     class="form-group">
                                    <label class="control-label">FODINFA</label>
                                    <el-input-number v-model="form.fodinfa"
                                                :max="1"
                                                :min="0.001"
                                                dusk="name"></el-input-number>
                                    <small v-if="errors.fodinfa"
                                           class="form-control-feedback"
                                           v-text="errors.fodinfa[0]"></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div :class="{'has-danger': errors.active}"
                                     class="form-group">
                                    <label class="control-label">Habilitar partida? </label>
                                    <el-switch
                                        v-model="form.active"
                                        class="ml-2"
                                        inline-prompt
                                        style="--el-switch-on-color: #13ce66; --el-switch-off-color: #ff4949"
                                        active-text="Si"
                                        inactive-text="No"
                                    />
                                    <small v-if="errors.fodinfa"
                                           class="form-control-feedback"
                                           v-text="errors.fodinfa[0]"></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div :class="{'has-danger': errors.eu_aviabilitie}"
                                     class="form-group">
                                     <label class="control-label">Union Europea?</label>
                                    <el-switch
                                        v-model="form.eu_aviabilitie"
                                        class="ml-2"
                                        active-text="Si"
                                        inactive-text="No"
                                        style="--el-switch-on-color: #13ce66; --el-switch-off-color: #ff4949"
                                    />
                                    <small v-if="errors.eu_aviabilitie"
                                           class="form-control-feedback"
                                           v-text="errors.eu_aviabilitie[0]"></small>
                                </div>
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

import {serviceNumber} from '../../../mixins/functions'

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
            form_zone: {add: false, name: null, id: null},
            parent: null,
            loading_submit: false,
            titleDialog: null,
            titleTabDialog: null,
            typeDialog: null,
            resource: 'imports',
            errors: {},
            api_service_token: false,
            form: {
                optional_email: []
            },
            temp_optional_email: [],
            temp_email: null,
            countries: [],
            zones: [],
            sellers: [],
            parteRel:[
                {'id': 1, 'name':'SI'},
                {'id': 2, 'name':'NO'},
            ],
            pagoLocExt:[
                {'id': 1, 'name':'Local'},
                {'id': 2, 'name':'Exterior'},
            ],
            pagoLocExtDoc:[
                {'id': 1, 'name':'Natural'},
                {'id': 2, 'name':'Sociedad'},
            ],
            person_types: [],
            identity_document_types: [],
            discount_types: [],
            activeName: 'first',
            isEditForm : false,
            estados: [{'id':1,'description':'Registrada'},{'id':2,'description':'Liberada'},{'id':3,'description':'Liquidada'}],
            tipoTransportes : [{'id':1,'description':'Aereo'},{'id':2,'description':'Maritimo'},{'id':3,'description':'Terrestre'}],
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
            this.resource = 'tariff'

        },
        async opened() {

        },
        create() {

            this.titleDialog = (this.recordId) ? 'Editar Partida Arancelaria' : 'Nueva Partida Arancelaria';
            this.titleTabDialog = 'Datos de la partida arancelaria';
            this.typeDialog = (this.recordId) ? 'Editar' : 'Guardar';
            this.isEditForm = (this.recordId) ? true : false;
            if (this.recordId) {
                this.$http.get(`/${this.resource}/record/${this.recordId}`)
                    .then(response => {
                        console.log('DATOS A EDITAR: ', response.data.data)
                        this.form = response.data.data
                        this.form.active = (response.data.data.active > 0) ? true:false
                        this.form.eu_aviabilitie = (response.data.data.eu_aviabilitie > 0) ? true:false

                    }).then(() => {

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
