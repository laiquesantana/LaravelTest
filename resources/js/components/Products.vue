<template>
  <div>
    <!--  <b-form class="mt-5" @submit.prevent="mode === 'save' ? save() : update()">
  

      <b-col xs="12" class="mt-2">
        <b-button type="submit" variant="primary" v-if="mode === 'save'">Salvar</b-button>
        <b-button type="submit" variant="success" v-if="mode === 'update'">update</b-button>
        <b-button class="ml-2" @click="reset">Cancelar</b-button>
      </b-col>
    </b-form>-->
    <h3>Product List</h3>
    <div class="card-tools pt-5">
      <button class="btn btn-success" >
           <i class="fas fa-plus fa-fw"></i>  Add a product
   
      </button>
    </div>
    <hr />
    <b-card-text>
      <b-row>
        <b-col lg="6" class="my-1">
          <b-form-group
            label="Search"
            label-cols-sm="1"
            label-for="filterInput"
            class="mb-1"
          >
            <b-input-group size="sm">
              <b-form-input
                v-model="filter"
                label-align-sm="left"
                type="search"
                id="filterInput"
                placeholder="search"
              ></b-form-input>
              <b-input-group-append>
                <b-button :disabled="!filter" @click="filter = ''">Clear</b-button>
              </b-input-group-append>
            </b-input-group>
          </b-form-group>
        </b-col>
      </b-row>
    </b-card-text>
    <b-card
      border-variant="primary"
      header="List Of Products"
      header-bg-variant="primary"
      header-text-variant="white"
      align="center"
      class="mb-1"
    >
      <!-- /.card-header -->
      <div class="card-body table-responsive p-0">
        <b-table
          responsive="sm"
          hover
          striped
          fixed
          bordered
          head-variant="success"
          :filter="filter"
          :busy.sync="isBusy"
          :items="product"
          :fields="fields"
          :current-page="currentPage"
          :per-page="perPage"
          @filtered="onFiltered"
        >
          <template v-slot:cell(actions)="data">
            <div class="btn-group-vertical">
              <div class="btn-group">
                <button
                  type="button"
                  class="btn btn-info"
                  data-toggle="dropdown"
                  aria-expanded="true"
                >
                  <i class="fas fa-ellipsis-v"></i>
                </button>
                <ul
                  class="dropdown-menu"
                  x-placement="bottom-start"
                  style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px);"
                >
                  <li>
                    <a
                      class="dropdown-item"
                      href="#"
                      @click.prevent="detailtProductModo(data.item)"
                    >Detail</a>
                  </li>
                  <li>
                    <a
                      class="dropdown-item"
                      href="#"
                      @click.prevent="deleteProducts(data.item.id)"
                    >Delete</a>
                  </li>
                </ul>
              </div>
            </div>
          </template>

          <template v-slot:cell(active)="data">
            <b-col md="6" class="mb-3" v-if="data.item.active === 'Yes'">
              <b-icon icon="circle-fill" variant="success"  font-scale="1"></b-icon>
            </b-col>
            <b-col md="6" class="mb-3" v-if="data.item.active === 'No'">
              <b-icon icon="circle-fill" variant="danger" font-scale="1"></b-icon>
            </b-col>
          </template>
          <template v-slot:cell(image)="data">
            <div class="p-2">

              <v-img :src="'img/productImage/'+data.item.image" alt="image" height="100px"></v-img>
            </div>
          </template>
          <template v-slot:table-busy>
            <div class="text-center text-danger my-2">
              <b-spinner class="align-middle"></b-spinner>
              <strong>loading...</strong>
            </div>
          </template>
        </b-table>
        <div class="card-footer">
            <b-form-row>
          <b-col sm="6" md="6" class="my-1">
            <b-form-group
              label="Product / page"
              label-cols-sm="6"
              label-cols-md="4"
              label-cols-lg="3"
              label-align-sm="fill"
              label-size="sm"
              label-for="perPageSelect"
              class="mb-0"
            >
              <b-form-select class="cold-md-4" v-model="perPage" id="perPageSelect" size="sm" :options="pageOptions"></b-form-select>
            </b-form-group>
          </b-col>
          <b-col sm="7" md="6" class="my-1">
            <b-pagination
              v-model="currentPage"
              :total-rows="totalRows"
              :per-page="perPage"
              align="fill"
              size="sm"
              class="my-3"
            ></b-pagination>
          </b-col>
            </b-form-row>
        </div>
      </div>
    </b-card>
  </div>
</template>

<script>
export default {
  data: function () {
    return {
      mode: "save",
      Products: {
        name: "",
        image: "",
        ref: "",
        category: "",
        price_ht: "",
        quantity: "",
        active: "",
      },
      product: [],
      errors: {},
      success: true,
      isBusy: false,
      action: "api/product",
      filter: null,
      perPage: 5,
      pageOptions: [5, 10, 15, 20],
      totalRows: 1,
      currentPage: 1,

      perPage: 5,
      fields: [
        { key: "id", label: "Id", sortable: true },
        { key: "image", label: "Image", sortable: true },
        {
          key: "ref",
          label: "Ref",
          sortable: true,

          formatter: (value) => value.toUpperCase(),
        },
        {
          key: "name",
          label: "Name ",
          sortable: true,
          formatter: (value) => value.toUpperCase(),
        },

        {
          key: "category",
          label: "Category ",
          sortable: true,
          formatter: (value) => value.toUpperCase(),
        },

        {
          key: "price_ht",
          label: "Price HT ",
          sortable: true,
          formatter: (value) =>
            new Intl.NumberFormat("de-DE", {
              style: "currency",
              currency: "EUR",
            }).format(value),
        },

        {
          key: "quantity",
          label: "Quantity ",
          sortable: true,
        },

        {
          key: "active",
          label: "Active ",
          sortable: true,
        },

        { key: "actions", label: " " },
      ],
    };
  },
  methods: {
    onFiltered(filteredItems) {
      // Trigger pagination to update the number of buttons/pages due to filtering
      this.totalRows = filteredItems.length;
      this.currentPage = 1;
    },

    reset() {
      this.mode = "save";
      this.Products = {
        name: "",
        category: "",
        created_at: "",
        image: "",
        price_ht: "",
        quantity: "",
        ref: "",
        active: "",
      };
      this.loadProducts();
    },
    toggleBusy() {
      this.isBusy = !this.isBusy;
    },
    save() {
      this.toggleBusy();
      this.$Progress.start();
      this.success = false;
      this.errors = {};
      axios
        .post(this.action, this.Products)
        .then((response) => {
          this.success = true;
          this.$toasted.global.defaultSuccess({
            msg: "Unidade de Medida cadastrada com sucesso!",
          });
          this.reset();
          this.$Progress.finish();
          this.toggleBusy();
        })
        .catch((error) => {
          this.loaded = true;
          if (error.response.status === 422) {
            this.errors = error.response.data.errors || {};
          }
          Toast.fire({
            icon: "error",
            title: "Ops Houve Um Problema No Formulário, Tente Novamente!",
          });

          this.$Progress.fail();
          this.toggleBusy();
        });
    },
    update() {
      this.toggleBusy();
      this.$Progress.start();
      this.success = false;
      this.errors = {};
      axios
        .put(this.action + "/" + this.Products.id, this.Products)
        .then((response) => {
          this.success = true;
          this.$toasted.global.defaultSuccess({
            msg: "Unidade de Medida atualizada com sucesso!",
          });
          this.reset();
          this.$Progress.finish();
          this.toggleBusy();
        })
        .catch((error) => {
          this.loaded = true;
          if (error.response.status === 422) {
            this.errors = error.response.data.errors || {};
          }
          Toast.fire({
            icon: "error",
            title: "Ops Houve Um Problema No Formulário, Tente Novamente!",
          });

          this.$Progress.fail();
          this.toggleBusy();
        });
    },
    loadProducts() {
      axios
        .get(this.action)
        .then(
          (res) => (
            (this.product = res.data), (this.totalRows = res.data.length)
          )
        );
    },
    deleteProducts(id) {
      swal
        .fire({
          title: "Are you sure?",
          text: "This action cannot be reversed!!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete!",
          cancelButtonText: "Cancel!",
        })
        .then((result) => {
          if (result.value) {
            //send request to the server
            axios
              .delete(this.action + "/" + id)
              .then((response) => {
                swal.fire(
                  "Deleted!",
                  "Product successfully deleted!",
                  "success"
                );
                this.loadProducts();
              })
              .catch((error) => {
                swal.fire(
                  "Error!",
                  "Oops something went wrong, try again later",
                  "error"
                );
              });
          }
        });
    },

    detailtProductModo(products_data, mode = "update") {
      this.mode = mode;
      this.Products = { ...products_data };

      this.$router.push({ name: 'product-detail', query: { 'productId': this.Products.id} }) 

    },
  },
  mounted() {
    this.loadProducts();
  },
};
</script>

<style>
</style>