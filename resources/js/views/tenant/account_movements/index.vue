<template>
    <div>
        <div class="page-header pr-0">
            <h2><a href="/dashboard"><i class="fas fa-tachometer-alt"></i></a></h2>
            <ol class="breadcrumbs">
                <li class="active"><span>{{ title }}</span></li>
            </ol>
            <div class="right-wrapper pull-right">
                <button type="button" class="btn btn-custom btn-sm  mt-2 mr-2" @click.prevent="clickCreate()"><i class="fa fa-plus-circle"></i> Nuevo</button>
            </div>
        </div>
        <div class="card mb-0">
            <div class="card-header bg-info">
                <h3 class="my-0">{{ title }}</h3>
            </div>
            <div class="card-body">
                <data-table :resource="resource">
                    <tr slot="heading">
                        <th>#</th>
                        <th>Código Cuenta</th>
                        <th>Descripción</th>
                        <th>Grupo</th>
                        <th>Centro Costo</th>
                        <th>Tipo</th>
                        <th>Fecha registro</th>
                        <th class="text-center">Acciones</th>
                    <tr>
                    <tr slot-scope="{ index, row }">
                        <td>{{ index }}</td>
                        <td>{{ row.code }}</td>
                        <td>{{ row.description }}</td>
                        <td>{{ row.group }}</td>
                        <td class="text-center">{{ row.cost_center?'SI':'NO' }}</td>
                        <td>{{ row.type }}</td>
                        <td>{{ row.created_at }}</td>
                        <td class="text-right" style="display: flex;justify-content: center;">
                            <button type="button" class="btn waves-effect waves-light btn-xs btn-info" @click.prevent="clickCreate(row.id)">Editar</button>
                             <template v-if="typeUser === 'admin'">
                            <div v-if="row.in_use===false">
                             <button type="button" class="btn waves-effect waves-light btn-xs btn-danger ml-2" @click.prevent="clickDelete(row.id)">Eliminar</button>
                            </div>
                             </template>
                        </td>
                    </tr>
                </data-table>
            </div>

            <person-types-form :showDialog.sync="showDialog"
                          :recordId="recordId" ></person-types-form>
 
        </div>
    </div>
</template>

<script>

    import PersonTypesForm from './form.vue'
    import DataTable from '../../../components/DataTable.vue'
    import {deletable} from '../../../mixins/deletable'

    export default {
        props:['typeUser'],
        mixins: [deletable],
        components: {PersonTypesForm, DataTable},
        data() {
            return {
                title: null,
                showDialog: false,
                resource: 'accounts-movements',
                recordId: null,
            }
        },
        created() {
            this.title = 'Cuentas Movimientos'
        },
        methods: {
            clickCreate(recordId = null) {
                this.recordId = recordId
                this.showDialog = true
            },

            clickDelete(id) {
                this.destroy(`/${this.resource}/${id}`).then(() =>
                    this.$eventHub.$emit('reloadData')
                )
            }
        }
    }
</script>
