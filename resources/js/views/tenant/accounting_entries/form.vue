<template>
  <div class="card mb-0 pt-2 pt-md-0">
    <div class="page-header pr-0">
      <h2>
        <a href="/dashboard"><i class="fas fa-tachometer-alt"></i></a>
      </h2>
      <ol class="breadcrumbs">
        <li class="active"><span>Crear Asiento Contable</span></li>
      </ol>
    </div>
    <div class="tab-content" v-if="loading_form">
      <div class="invoice">
        <div class="form-body">
          <div class="row mt-1">
            <div class="col-lg-6">
              <div
                class="form-group row"
                :class="{ 'has-danger': errors.seat_date }"
              >
                <label
                  class="col-sm-4 col-form-label font-weight-bold text-info"
                  >Fecha:</label
                >
                <div class="col-sm-6">
                  <el-date-picker
                    v-model="seat_date"
                    type="date"
                    value-format="yyyy-MM-dd"
                    :clearable="false"
                  ></el-date-picker>
                </div>
                <small
                  class="form-control-feedback"
                  v-if="errors.seat_date"
                  v-text="errors.seat_date[0]"
                ></small>
              </div>
            </div>
          </div>

          <div class="row mt-1">
            <div class="col-lg-6">
              <div class="form-group row">
                <label
                  class="col-sm-4 col-form-label font-weight-bold text-info"
                  >Comentarios:</label
                >
                <div class="col-sm-8">
                  <el-input v-model="comment"></el-input>
                  <small
                    class="form-control-feedback"
                    v-if="errors.comment"
                    v-text="errors.comment[0]"
                  ></small>
                </div>
              </div>
            </div>
          </div>

          <div class="row mt-1">
            <div class="col-lg-6">
              <div class="form-group row">
                <label
                  class="col-sm-4 col-form-label font-weight-bold text-info"
                  >Tipo Asiento:</label
                >
                <div class="col-sm-8">
                  <el-select
                    v-model="types_accounting_entrie_id"
                    filterable
                    :class="{
                      'h-danger': errors['items.0.types_accounting_entrie_id'],
                    }"
                  >
                    <el-option
                      v-for="option in types_seat"
                      :key="option.id"
                      :value="option.id"
                      :label="option.name"
                    ></el-option>
                  </el-select>
                  <small
                    class="text-danger"
                    v-if="errors['items.0.types_accounting_entrie_id']"
                    v-text="errors['items.0.types_accounting_entrie_id'][0]"
                  ></small>
                </div>
              </div>
            </div>
          </div>

          <div class="row mt-1">
            <div class="col-lg-8">
              <div class="form-group row">
                <div class="col-sm-3 font-weight-bold text-info">
                  <el-select v-model="is_client" readonly="true">
                    <el-option
                      v-for="option in tipo_cliente"
                      :key="option.id"
                      :value="option.id"
                      :label="option.name"
                    ></el-option>
                  </el-select>
                </div>

                <div class="col-sm-8 flex d-flex" v-if="is_client == 0">
                  <el-select
                   :class="{'h-danger': errors['items.0.person_id']}"
                    v-model="customer_id"
                    filterable
                    remote
                    dusk="customer_id"
                    placeholder="Escriba el nombre o número de documento del cliente"
                    :remote-method="searchRemoteCustomers"
                    @focus="focus_on_client = true"
                    @blur="focus_on_client = false"
                    :loading="loading_search"
                  >
                    <el-option
                      v-for="option in customers"
                      :key="option.id"
                      :value="option.id"
                      :label="option.description"
                    ></el-option>
                  </el-select>
                  <a
                    class="col-md-3 d-flex align-items-center"
                    href="#"
                    @click.prevent="showDialogNewPerson = true"
                    >[+ Nuevo]</a
                  >
                </div>

                <div class="col-sm-8 flex d-flex" v-if="is_client == 1">
                  <el-select
                    :class="{'h-danger': errors['items.0.person_id']}"
                    v-model="supplier_id"
                    filterable
                    remote
                    class="border-left rounded-left border-info"
                    popper-class="el-select-customers"
                    dusk="supplier_id"
                    placeholder="Escriba el nombre o número de documento del proveedor"
                    :remote-method="searchRemoteSuppliers"
                    @focus="focus_on_client = true"
                    @blur="focus_on_client = false"
                    :loading="loading_search"
                  >
                    <el-option
                      v-for="option in suppliers"
                      :key="option.id"
                      :value="option.id"
                      :label="option.description"
                    ></el-option>
                  </el-select>
                  <a
                    class="col-md-3 d-flex align-items-center"
                    href="#"
                    @click.prevent="showDialogNewSupplier = true"
                    >[+ Nuevo]</a
                  >
                </div>
			<div class="offset-md-3 col-md-8">
              <small
                class="text-danger"
                v-if="errors['items.0.person_id']"
                v-text="errors['items.0.person_id'][0]"
              ></small>
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
                      <th class="font-weight-bold" width="30%">Cuenta</th>
                      <th width="15%" class="text-center font-weight-bold">
                        Debe
                      </th>
                      <th width="15%" class="text-center font-weight-bold">
                        Haber
                      </th>
                      <th class="text-center font-weight-bold">Centro costo</th>
                      <th class="text-center font-weight-bold" width="8%"></th>
                    </tr>
                  </thead>
                  <tbody v-if="form.items.length > 0">
                    <tr v-for="(row, index) in form.items" :key="index">
                      <td>{{ index + 1 }}</td>
                      <td>
                        <div
                          class="input-group"
                          :class="{
                            'h-danger':
                              errors['items.' + index + '.account_movement_id'],
                          }"
                        >
                          <el-input
                            v-model="row.cuenta"
                            :readonly="true"
                            class="cursor-pointer form-control borde-0 p-0"
                            type="text"
                          ></el-input>
                          <div class="input-group-append">
                            <button
                              class="btn btn-outline-secondary"
                              style="border-color: #ced4da"
                              type="button"
                              @click="clickAddItem(index)"
                            >
                              <i class="fa fa-search"></i>
                            </button>
                          </div>
                        </div>
                        <small
                          class="text-danger"
                          v-if="
                            errors['items.' + index + '.account_movement_id']
                          "
                          v-text="
                            errors['items.' + index + '.account_movement_id'][0]
                          "
                        ></small>
                      </td>
                      <td class="text-center">
                        <el-input-number
                          v-model="row.debe"
                          :controls="false"
                          :min="0.0"
                          :precision="precision"
                          @input="calculateTotal()"
                          prefix-icon="feather feather-dollar-sign"
                        ></el-input-number>
                      </td>
                      <td class="text-center">
                        <el-input-number
                          v-model="row.haber"
                          :controls="false"
                          :min="0.0"
                          :precision="precision"
                          @input="calculateTotal()"
                          prefix-icon="feather feather-dollar-sign"
                        >
                        </el-input-number>
                      </td>
                      <td class="text-center">
                        <el-input
                          :class="{
                            'h-danger': errors['items.' + index + '.seat_cost'],
                          }"
                          v-model="row.seat_cost"
                        ></el-input>
                        <small
                          class="text-danger"
                          v-if="errors['items.' + index + '.seat_cost']"
                          v-text="errors['items.' + index + '.seat_cost'][0]"
                        ></small>
                      </td>
                      <td class="series-table-actions text-center">
                        <div v-if="index > 1">
                          <button
                            type="button"
                            class="btn waves-effect waves-light btn-xs btn-danger"
                            @click.prevent="clickRemoveItem(index)"
                          >
                            <i class="fa fa-trash"></i>
                          </button>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td></td>
                      <td></td>
                      <td class="border-top border-dark">
                        <el-input-number
                          v-model="total_debe"
                          :controls="false"
                          :min="0.0"
                          :disabled="true"
                          :precision="precision"
                          prefix-icon="\E749"
                        ></el-input-number>
                      </td>
                      <td class="border-top border-dark">
                        <el-input-number
                          v-model="total_haber"
                          :controls="false"
                          :min="0.0"
                          disabled
                          :precision="precision"
                          prefix-icon="feather feather-dollar-sign"
                        ></el-input-number>
                      </td>
                      <td></td>
                      <td></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <p class="text-center text-success" v-if="habilitado === true">
                ASIENTO CORRECTO SE PUEDE GUARDAR
              </p>
              <p class="text-center text-danger" v-if="habilitado === false">
                ASIENTO DESCUADRADO NO SE GUARDA
              </p>
            </div>
            <div class="col-lg-12 col-md-6 d-flex align-items-end">
              <div class="form-group">
                <button
                  type="button"
                  class="btn waves-effect waves-light btn-primary"
                  @click="addNewRow"
                >
                  + Agregar Detalle
                </button>
              </div>
            </div>
          </div>
        </div>

        <div class="form-actions text-right mt-4">
          <el-button @click.prevent="close()">Cancelar</el-button>
          <el-button
            class="submit"
            type="primary"
            native-type="submit"
            :loading="loading_submit"
            v-if="habilitado === true"
            @click.prevent="submit"
            >Generar</el-button
          >
        </div>
      </div>
    </div>

    <account-form
      :showDialog.sync="showDialogAddItem"
      :typeUser="typeUser"
      :configuration="config"
      :row-id="row_id"
      @add="addRow"
    ></account-form>
    <person-form
      :showDialog.sync="showDialogNewPerson"
      type="customers"
      :external="true"
      :input_person="input_person"
      :document_type_id="form.document_type_id"
    ></person-form>

    <supplier-form
      :external="true"
      :input_person="input_person"
      :showDialog.sync="showDialogNewSupplier"
      type="suppliers"
    ></supplier-form>
  </div>
</template>

<script>
import AccountForm from "./partials/item.vue";
import PersonForm from "../persons/form.vue";
import SupplierForm from "../persons/form.vue";
import { functions, exchangeRate } from "../../../mixins/functions";
import { mapActions, mapState } from "vuex/dist/vuex.mjs";

export default {
  props: ["typeUser", "configuration"],
  components: { AccountForm, PersonForm, SupplierForm },
  mixins: [functions, exchangeRate],
  data() {
    return {
      resource: "accounting-entries",
      showDialogAddItem: false,
      loading_submit: false,
      loading_form: false,
      types_accounting_entrie_id: null,
      person_id: 0,
      is_client: 0,
      seat_date: moment().format("YYYY-MM-DD"),
      comment: null,
      precision: 2,
      userid: null,
      habilitado: true,
      showDialogNewPerson: false,
      showDialogNewSupplier: false,
      errors: {},
      customers: [],
      all_customers: [],
      all_suppliers: [],
      supplier_id: null,
      customer_id: null,

      suppliers: [],
      form: {},
      focus_on_client: false,
      loading_search: false,
      tipo_cliente: [
        { id: 0, name: "Cliente" },
        { id: 1, name: "Proveedor" },
      ],
      types_seat: [],
      quotationNewId: null,
      total_haber: 0.0,
      total_debe: 0.0,
      row_id: null,
      input_person: {},
    };
  },
  async created() {
    this.loadConfiguration();
    this.$store.commit("setConfiguration", this.configuration);
    await this.initForm();
    await this.$http.get(`/${this.resource}/tables`).then((response) => {
      const data = response.data;
      this.userid = data.user.id;
      this.all_customers = data.customers;
      this.all_suppliers = data.suppliers;
      this.types_seat = data.types_seat;
      this.allCustomers();
      this.allSuppliers();
    });
    this.loading_form = true;
  },
  computed: {
    ...mapState(["config"]),
  },
  methods: {
    ...mapActions(["loadConfiguration"]),

    clickAddItem(index) {
      this.row_id = index;
      this.showDialogAddItem = true;
    },

    initForm() {
      this.errors = {};
      (this.seat_date = moment().format("YYYY-MM-DD")),
	  this.comment=null;
	  this.types_accounting_entrie_id=null;
	  this.customer_id=null;
	  this.supplier_id=null;
        (this.form = {
          items: [
            {
              user_id: null,
              seat: "",
              seat_general: "",
              seat_line: null,
              debe: 0.0,
              haber: 0.0,
              seat_date: null,
              account_movement_id: null,
              comment: null,
              types_accounting_entrie_id: null,
              seat_cost: null,
              is_client: 0,
              person_id: 0,
            },
            {
              user_id: null,
              seat: "",
              seat_general: "",
              seat_line: null,
              debe: 0.0,
              haber: 0.0,
              seat_date: null,
              account_movement_id: null,
              comment: null,
              types_accounting_entrie_id: null,
              seat_cost: null,
              is_client: 0,
              person_id: 0,
            },
          ],
        });
    },
    resetForm() {
      this.initForm();
    },

    addRow(row) {
      this.form.items = this.form.items.map((item, index) => {
        if (row.item_id == index) {
          item.cuenta = row.name;
          item.account_movement_id = row.id;
          item.typecost = row.cost;
        }
        return item;
      });
    },

    addNewRow() {
      this.form.items.push({
        user_id: null,
        seat: "",
        seat_general: "",
        seat_line: null,
        debe: 0.0,
        haber: 0.0,
        seat_date: null,
        account_movement_id: null,
        comment: null,
        types_accounting_entrie_id: null,
        seat_cost: null,
        is_client: 0,
        person_id: 0,
      });
      this.calculateTotal();
    },

    searchRemoteCustomers(input) {
      if (input.length > 0) {
        this.loading_search = true;
        let parameters = `input=${input}`;

        this.$http
          .get(`/${this.resource}/search/customers?${parameters}`)
          .then((response) => {
            this.customers = response.data.customers;
            this.loading_search = false;
            this.input_person.number =
              this.customers.length == 0 ? input : null;
          });
      } else {
        this.allCustomers();
        this.input_person.number = null;
      }
    },
    searchRemoteSuppliers(input) {
      if (input.length > 0) {
        this.loading_search = true;
        let parameters = `input=${input}`;

        this.$http
          .get(`/${this.resource}/search/customers?${parameters}`)
          .then((response) => {
            this.customers = response.data.customers;
            this.loading_search = false;
            this.input_person.number =
              this.customers.length == 0 ? input : null;
          });
      } else {
        this.allCustomers();
        this.input_person.number = null;
      }
    },
    allCustomers() {
      this.customers = this.all_customers;
    },
    allSuppliers() {
      this.suppliers = this.all_suppliers;
    },

    clickRemoveItem(index) {
      this.form.items.splice(index, 1);
      this.calculateTotal();
    },

    calculateTotal() {
      let total_debe = 0.0;
      let total_haber = 0.0;

      this.form.items.forEach((row) => {
        total_debe += parseFloat(row.debe);
        total_haber += parseFloat(row.haber);
      });
      this.total_debe = _.round(total_debe, 2);
      this.total_haber = _.round(total_haber, 2);
      if (
        this.total_debe == this.total_haber &&
        this.total_debe > 0 &&
        this.total_haber > 0
      ) {
        this.habilitado = true;
      } else {
        this.habilitado = false;
      }
    },

    //guardar
    async submit() {
      if (this.is_client == 0) {
        this.person_id = this.customer_id;
      } else {
        this.person_id = this.supplier_id;
      }

      this.form.items = this.form.items.map((item, index) => {
        item.seat_line = index + 1;
        item.types_accounting_entrie_id = this.types_accounting_entrie_id;
        item.user_id = this.userid;
        item.seat_date = this.seat_date;
        item.comment = this.comment;
        item.is_client = this.is_client;
        item.person_id = this.person_id;

        return item;
      });
      this.loading_submit = true;
      console.log("res ", this.form);
      await this.$http
        .post(`/${this.resource}`, this.form)
        .then((response) => {
          if (response.data.success) {
            this.resetForm();
            this.quotationNewId = response.data.data.id;
          } else {
            this.$message.error(response.data.message);
          }
        })
        .catch((error) => {
          if (error.response.status === 422) {
            this.errors = error.response.data;
          } else {
            this.$message.error(error.response.data.message);
          }
        })
        .then(() => {
          this.loading_submit = false;
        });
    },
    close() {
      location.href = "/accounting-entries";
    },
  },
};
</script>
