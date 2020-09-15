<template>
  <div>
    <b-form class="mt-5" @submit.prevent="mode === 'save' ? save() : update()">
  

      <b-col xs="12" class="mt-2">
        <b-button type="submit" variant="primary" v-if="mode === 'save'">Salvar</b-button>
        <b-button type="submit" variant="success" v-if="mode === 'update'">update</b-button>
        <b-button class="ml-2" @click="reset">Cancelar</b-button>
      </b-col>
    </b-form>
    <hr />

    <b-card
      border-variant="primary"
      header="List Of Products"
      header-bg-variant="primary"
      header-text-variant="white"
      align="center"
      class="mb-1"
    >
      <b-card-text>
        <b-row>
        
          <b-col lg="6" class="my-1">
            <b-form-group
              label="Filtro"
              label-cols-sm="3"
              label-align-sm="right"
              label-size="sm"
              label-for="filterInput"
              class="mb-2"
            >
              <b-input-group size="sm">
                <b-form-input
                  v-model="filter"
                  label-align-sm="left"
                  type="search"
                  id="filterInput"
                  placeholder="Escreva para buscar"
                ></b-form-input>
                <b-input-group-append>
                  <b-button :disabled="!filter" @click="filter = ''">Limpar</b-button>
                </b-input-group-append>
              </b-input-group>
            </b-form-group>
          </b-col>
        </b-row>
      </b-card-text>

      <!-- /.card-header -->
      <div class="card-body table-responsive p-0">
        <b-table
          responsive="sm"
          hover
          striped
          fixed
          bordered
          :filter="filter"
          :busy.sync="isBusy"
          :items="Product"
          :fields="fields"
          :current-page="currentPage"
          :per-page="perPage"
          @filtered="onFiltered"
        >
          <template v-slot:cell(actions)="data">
            <b-button variant="outline-success" @click="loadProductModo(data.item)">
              <b-icon icon="check-box" aria-hidden="true"></b-icon>Editar
            </b-button>
            <b-button pill variant="outline-danger" @click="deleteProducts(data.item.id)">
              <b-icon icon="trash-fill" aria-hidden="true"></b-icon>Excluir
            </b-button>
          </template>
          <template v-slot:table-busy>
            <div class="text-center text-danger my-2">
              <b-spinner class="align-middle"></b-spinner>
              <strong>loading...</strong>
            </div>
          </template>
        </b-table>
        <div class="card-footer">
            <b-col sm="7" md="4" class="my-1">
            <b-form-group
              label="Product / page"
              label-cols-sm="6"
              label-cols-md="4"
              label-cols-lg="3"
              label-align-sm="left"
              label-size="sm"
              label-for="perPageSelect"
              class="mb-0"
            >
              <b-form-select v-model="perPage" id="perPageSelect" size="sm" :options="pageOptions"></b-form-select>
            </b-form-group>
          </b-col>
          <b-col sm="7" md="6" class="my-1">
            <b-pagination
              v-model="currentPage"
              :total-rows="totalRows"
              :per-page="perPage"
              align="fill"
              size="sm"
              class="my-0"
            ></b-pagination>
          </b-col>
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
        nome: "",
        sigla: "",
      },
      Product: [],
      errors: {},
      success: true,
      isBusy: false,
      action: "api/products",
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
        nome: "",
        sigla: "",
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
            (this.Product = res.data), (this.totalRows = res.data.length)
          )
        );
    },
    deleteProducts(id) {
      swal
        .fire({
          title: "você tem certeza?",
          text: "Está ação não poderá ser revertida!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Sim, deletar!",
          cancelButtonText: "Cancelar!",
        })
        .then((result) => {
          if (result.value) {
            //send request to the server
            axios
              .delete("api/unidade-medida/" + id)
              .then((response) => {
                swal.fire(
                  "Deletado!",
                  "Unidade de medida deletada com sucesso!",
                  "success"
                );
                this.loadProducts();
              })
              .catch((error) => {
                swal.fire(
                  "Falha!",
                  "Problema ao deletar Unidade de medida",
                  "error"
                );
              });
          }
        });
    },

    loadProductModo(unidadesMedidas, mode = "update") {
      this.mode = mode;
      this.products = { ...unidadesMedidas };
    },
  },
  mounted() {
    this.loadProducts();
  },
};
</script>

<style>
</style>