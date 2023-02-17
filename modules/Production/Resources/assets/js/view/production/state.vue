<template>
    <div class="card mb-0 pt-2 pt-md-0">
        <div class="card-header bg-info">
            <h3 class="my-0">
                Estado Actual
            </h3>
        </div>
        <div class="tab-content">
            <form autocomplete="off"
                  @submit.prevent="submit">
                <div class="form-body">
                    <div class="row">
                        <div class="col">
                            <div
                                :class="{'has-danger': errors.records_id}"
                                class="form-group"
                            >
                                <label class="control-label">Estado</label>
                                <el-select v-model="form.records_id"
                                           filterable>
                                    <el-option
                                        v-for="option in records"
                                        :key="option.id"
                                        :label="option.description"
                                        :value="option.id"
                                    ></el-option>
                                </el-select>
                                <small
                                    v-if="errors.records_id"
                                    class="form-control-feedback"
                                    v-text="errors.records_id[0]"
                                ></small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions text-right mt-4">
                    <el-button
                        :loading="loading_submit"
                        native-type="submit"
                        type="primary"
                    >Guardar
                    </el-button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    prop: ['id'],
    computed: {},
    data() {
        return {
            resource: 'production',
            loading_submit: false,
            errors: {},
            item: {},
            //supplies: {},
            form: {},
            records: [],
        }
    },
    created() {
        this.getTable();
        this.initForm()
    },
    methods: {
        initForm() {
            this.form = {
                id: this.id,
                records_id: null,
            }
            //this.supplies = {};

        },
        getTable() {
            this.$http.get(`/${this.resource}/tables`)
                .then(response => {
                    this.form.records_id = response.data.state_type_descr;
                    //this.records_id = response.data.state_types_id;
                    this.records = response.data.state_types_prod;
                })
        },
        async submit() {
            this.loading_submit = true

            //this.form.supplies = this.supplies
            await this.$http.post(`/${this.resource}/create`, this.form)
                .then(response => {
                    if (response.data.success) {
                        this.$message.success(response.data.message)
                        this.initForm()
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
    }
}
</script>