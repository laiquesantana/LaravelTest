<style >
.widget-user {
  height: 400px;
}
.widget-user .widget-user-header {
  background-position: center center;
  background-size: cover;
  height: 400px;
}
.widget-user .card-footer {
  padding: 0;
}
</style>


<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-widget widget-user mt-5">
          <!-- Add the bg color to the header using any of the bg-* classes -->
          <div
            class="widget-user-header text-white"
            style="background-image:url('./img/user-cover.jpg')"
          >
            <h3 class="widget-user-username text-left">{{this.fields.name }}</h3>
            <h5 class="widget-user-desc text-left mt-1">{{this.fields.tipo }}</h5>
          </div>
          <div class="widget-user-image">
            <img class="img-circle" src alt="User Avatar" />
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-sm-4 border-right">
                <div class="description-block">
                  <h5 class="description-header">{{this.fields.created_at | formatData}}</h5>
                  <span class="description-text">Data de Criação</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-4 border-right">
                <div class="description-block">
                  <h5 class="description-header">{{this.fields.updated_at | formatData}}</h5>
                  <span class="description-text">Ultima Atualização</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-4">
                <div class="description-block">
                  <h5 class="description-header">35</h5>
                  <span class="description-text">Mensagens</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
        </div>
        <!-- tab -->

        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item">
                <a class="nav-link" href="#activity" data-toggle="tab">Activity</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active show" href="#settings" data-toggle="tab">Settings</a>
              </li>
            </ul>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              <!-- Activity Tab -->
              <div class="tab-pane" id="activity">
                <h3 class="text-center">Display User Activity</h3>
              </div>
              <!-- Setting Tab -->
              <div class="tab-pane active show" id="settings">
                <form @submit.prevent="updateUser()" class="form-horizontal">
                  <div class="modal-body">
                    <div class="form-group">
                      <label for="name">Nome</label>
                      <input
                        type="text"
                        class="form-control"
                        name="name"
                        id="name"
                        v-model="fields.name"
                      />
                      <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div>
                    </div>

                    <div class="form-group">
                      <label for="email">E-mail</label>
                      <input
                        type="email"
                        class="form-control"
                        name="email"
                        id="email"
                        v-model="fields.email"
                      />
                      <div v-if="errors && errors.email" class="text-danger">{{ errors.email[0] }}</div>
                    </div>

                    <div class="form-group">
                      <label for="photo">Foto do Perfil</label>
                      <input
                        type="file"
                        class="form-control"
                        name="photo"
                        id="photo"
                        @change="updateProfile"
                      />
                      <div v-if="errors && errors.photo" class="text-danger">{{ errors.photo[0] }}</div>
                    </div>

                    <div class="form-group">
                      <label for="tipo">Tipo</label>
                      <select class="custom-select" id="tipo" name="tipo" v-model="fields.tipo">
                        <option value selected>Selecione...</option>
                        <option value="admin">Administrador</option>
                        <option value="default">Padrão</option>
                        <option value="gerente">Contrato</option>
                      </select>
                      <div v-if="errors && errors.tipo" class="text-danger">{{ errors.tipo[0] }}</div>
                    </div>

                    <div class="form-group">
                      <label for="password">Senha</label>
                      <input
                        type="password"
                        class="form-control"
                        name="password"
                        autocomplete="on"
                        id="password"
                        v-model="fields.password"
                      />
                      <div
                        v-if="errors && errors.password"
                        class="text-danger"
                      >{{ errors.password[0] }}</div>
                    </div>

                    <div class="form-group">
                      <button type="submit" class="btn btn-success">
                        Atualizar Usuário
                        <i class="fas fa-user-edit"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.nav-tabs-custom -->
        <!-- end tabs -->
      </div>
    </div>
  </div>
</template>

<script>
    export default {
        data() {
            return {
            fields: {},
            errors: {},
            success: false,
            loaded: true,
            };
        },
        mounted() {
            console.log("Component mounted.");
        },

        created() {
          this.loadProfile();
        },

        methods: {
            loadProfile(){
                this.$Progress.start()
                    axios
                    .get("api/profile")
                    .then(({ data }) => (this.fields = data), this.$Progress.finish())
                    .catch(error => {
                        Toast.fire({
                            icon: "error",
                            title: "Falha Ao Carregar Perfil Do Usuários!"
                        }),
                        this.$Progress.fail();
                    });
            }
            ,
            updateUser() {
            if (this.loaded) {
                this.$Progress.start();

                this.loaded = false;
                this.success = false;
                this.errors = {};
                axios
                .put("api/user/" + this.fields.id, this.fields)
                .then(response => {
                    this.loaded = true;
                    this.success = true;
                    $("#novoUsuario").modal("hide");
                    Toast.fire({
                        icon: "success",
                        title: "Perfil Atualizado com Sucesso !"
                    });
                    this.loadProfile();
                    this.$Progress.finish();
                })
                .catch(error => {
                    this.loaded = true;
                    this.success = false;
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors || {};
                    }
                    Toast.fire({
                        icon: "error",
                        title: "Ops Houve Um Problema No Formulário, Tente Novamente!"
                    });

                    this.$Progress.fail();
                });
            }
            },
            updateProfile(e) {
                console.log('updateProfile')
                let file = e.target.files[0];
                let reader = new FileReader();
                let limit = 1024 * 1024 * 2;
            if (file["size"] > limit) {
                swal({
                type: "error",
                title: "Oops...",
                text: "Tamanho do arquivo acima do permitido!"
                });
                return false;
            }
            reader.onloadend = file => {
                this.fields.photo = reader.result;
            };
            reader.readAsDataURL(file);
            }
        }
    };
</script>


