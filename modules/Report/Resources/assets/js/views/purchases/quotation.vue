<template>
    <div class="card mb-0 pt-2 pt-md-0">
        <div class="card-header bg-info">
            <h3 class="my-0">Consulta Cotizacion de Compra</h3>
        </div>
        <div class="card mb-0">
                <div class="card-body">
                    <data-table :resource="resource"  :applyCustomer="true" :colspanFootPurchase="9" :applyConversionToPen="applyConversionToPen">
                        <tr slot="heading">
                            <th class="">#</th>
                            <th class="">Item</th>
                            <th class="">Id</th>
                            <th class="">Precio</th>
                            <th class="">Cotizado</th>
                            <th class="">Ordenado</th>
                            <th class="">Comprado</th>
                        </tr>
                        <tr slot-scope="{ index, row }">
                            <td>{{ index }}</td>
                            <td>{{row.item}}</td>
                            <td>{{row.id}}</td>
                            <td>{{ row.price }}</td>
                            <td>{{row.cantCot}}</td>
                            <td>{{row.cantOrd}}</td>
                            <td>{{row.cantBuy}}</td>
                        </tr>
                    </data-table>
                </div>
        </div>

    </div>
</template>

<script>

    import DataTable from '../../components/DataTableReports.vue'

    export default {
        components: {DataTable},
        props:[
            'applyConversionToPen',
        ],
        data() {
            return {
                resource: 'reports/purchases/quotations',
                form: {},

            }
        },
        async created() {
        },
        methods: {


        }
    }
</script>
