<template>
    <div>
        <div class="card-body">

            <div class="col-md-12 col-lg-12 col-xl-12 ">

                <div class="row">
                    <div class="col-md-7 col-lg-7 col-xl-7">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label font-weight-bold">
                                Cuenta:
                            </label>
                            <div class="col-lg-8 col-md-8 col-sm-8 pb-2">
                                <el-input placeholder="Buscar"
                                    v-model="search.value"
                                    style="width: 100%;"
                                    @input="getRecords">
                                </el-input>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 col-lg-5 col-xl-5">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label font-weight-bold">
                                Desde:
                            </label>
                            <div class="col-lg-8 col-md-8 col-sm-8 pb-2">
                                <el-date-picker
                                    v-model="form.d_start"
                                    type="date"
                                    @change="changeDisabledDates"
                                    value-format="yyyy-MM-dd"
                                    format="dd/MM/yyyy"
                                    :clearable="true">
                                </el-date-picker>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-7 col-lg-7 col-xl-7">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label font-weight-bold">
                                Centro de costo:
                            </label>
                            <div class="col-lg-8 col-md-8 col-sm-8 pb-2">
                                <el-input placeholder="Buscar"
                                    v-model="search.value"
                                    style="width: 100%;"
                                    @input="getRecords">
                                </el-input>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 col-lg-5 col-xl-5">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label font-weight-bold">
                                Hasta:
                            </label>
                            <div class="col-lg-8 col-md-8 col-sm-8 pb-2">
                                <el-date-picker
                                    v-model="form.d_end"
                                    type="date"
                                    @change="changeDisabledDates"
                                    value-format="yyyy-MM-dd"
                                    format="dd/MM/yyyy"
                                    :clearable="true">
                                </el-date-picker>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-7 col-lg-7 col-xl-7">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label font-weight-bold">
                                Buscar:
                            </label>
                            <div class="col-lg-8 col-md-8 col-sm-8 pb-2">
                                <el-input placeholder="Buscar"
                                    v-model="search.value"
                                    style="width: 100%;"
                                    @input="getRecords">
                                </el-input>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 col-lg-5 col-xl-5">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label font-weight-bold">
                                Tipo:
                            </label>
                            <div class="col-lg-8 col-md-8 col-sm-8 pb-2">
                               <el-select v-model="form.period" @change="changePeriod">
                                <el-option key="month" value="month" label="Por mes"></el-option>
                                <el-option key="week" value="week" label="Por semana"></el-option>
                                <el-option key="between_dates" value="between_dates" label="Entre fechas"></el-option>
                            </el-select>
                            </div>
                        </div>
                    </div>
                </div>                

                <div class="row">
                    <div class="col">
                        <button type="button" class="btn btn-custom btn-sm  mt-2 mr-2" @click.prevent="clickCreate()"><i class="fa fa-search"></i> Consultar</button>
                    </div>
                </div>
            </div>
            </div>


            <div class="col-md-12 px-0 pt-3">
                <div class="table-responsive">
                    
                        <div>
                        <slot name="heading"></slot>
                        </div>
                        <div>
                        <slot v-for="(row, index) in records" :row="row" :index="customIndex(index)"></slot>
                        </div>
                    
                    <div>
                        <el-pagination
                                @current-change="getRecords"
                                layout="total, prev, pager, next"
                                :total="pagination.total"
                                :current-page.sync="pagination.current_page"
                                :page-size="pagination.per_page">
                        </el-pagination>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>


<script>
import moment from "moment";
import queryString from "query-string";

export default {
  props: {
    resource: String,
    applyFilter: {
      type: Boolean,
      default: true,
      required: false,
    },
  },
  data() {
    return {
      search: {
        column: null,
        form: null,
        value: null,
      },
      columns: [],
      records: [],
      form: {},
      pagination: {},
      pickerOptionsDates: {
        disabledDate: (time) => {
          time = moment(time).format("YYYY-MM-DD");
          return this.form.date_start > time;
        },
      },
      pickerOptionsMonths: {
        disabledDate: (time) => {
          time = moment(time).format("YYYY-MM");
          return this.form.month_start > time;
        },
      },
    };
  },
  computed: {},
  created() {
    this.initForm();
    this.$eventHub.$on("reloadData", () => {
      this.getRecords();
    });
  },
  async mounted() {
    let column_resource = _.split(this.resource, "/");
    console.log('d', column_resource);
    await this.$http
      .get(`/${_.head(column_resource)}/columns`)
      .then((response) => {
        this.columns = response.data;
        this.search.column = _.head(Object.keys(this.columns));
      });
    await this.getRecords();
  },
  methods: {
    changeDisabledDates() {
      if (this.form.date_end < this.form.date_start) {
        this.form.date_end = this.form.date_start;
      }

      this.selectDate();
    },
    selectDate() {
      this.form.date_start = null;
      this.form.date_end = null;

      if (this.form.period === "week" && this.form.week) {
        this.form.date_start = moment(this.form.week)
          .startOf("week")
          .format("YYYY-MM-DD");
        this.form.date_end = moment(this.form.week)
          .endOf("week")
          .format("YYYY-MM-DD");
      } else if (this.form.period === "month" && this.form.month) {
        this.form.date_start = moment(this.form.month)
          .startOf("month")
          .format("YYYY-MM-DD");
        this.form.date_end = moment(this.form.month)
          .endOf("month")
          .format("YYYY-MM-DD");
      } else {
        this.form.date_start = this.form.d_start;
        this.form.date_end = this.form.d_end;
      }

      this.getRecords();
    },
    changeDisabledMonths() {},
    changePeriod() {
      this.form.date_start = null;
      this.form.date_end = null;
      this.form.week = null;
      this.form.month = null;
      this.form.d_start = null;
      this.form.d_end = null;

      this.getRecords();
    },
    initForm() {
      this.form = {
        week: null,
        month: null,
        d_start: null,
        d_end: null,
        period: "between_dates",
        date_start: null,
        date_end: null,
      };
    },
    customIndex(index) {
      return (
        this.pagination.per_page * (this.pagination.current_page - 1) +
        index +
        1
      );
    },
    getRecords() {
      this.search.form = JSON.stringify(this.form);
      return this.$http
        .get(`/${this.resource}/records?${this.getQueryParameters()}`)
        .then((response) => {
          this.records = response.data.data;
          this.pagination = response.data.meta;
          this.pagination.per_page = parseInt(response.data.meta.per_page);
        });
    },
    getQueryParameters() {
      return queryString.stringify({
        page: this.pagination.current_page,
        limit: this.limit,
        ...this.search,
      });
    },
    changeClearInput() {
      this.search.value = "";
      this.getRecords();
    },
  },
};
</script>
