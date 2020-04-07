<template>
  <div class="container">
    <div class="row mt-5">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Lista de Usuários</h3>

            <div class="card-tools">
              <button class="btn btn-success" data-toggle="modal" data-target="#novoUsuario">
                Adicionar Novo Usuário
                <i class="fas fa-user-plus fa-fw"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nome</th>
                  <th>Email</th>
                  <th>Status</th>
                  <th>Tipo</th>
                  <th>Data Criação</th>
                  <th>Data Atualização</th>
                  <th>Modificar</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="user in users" :key="user.id">
                  <td>{{ user.id }}</td>
                  <td>{{ user.name }}</td>
                  <td>{{ user.email }}</td>
                  <td>{{ user.status | statusUsuario }}</td>
                  <td>{{ user.tipo | upText}}</td>
                  <td>{{ user.created_at | formatData}}</td>
                  <td>{{ user.updated_at | formatData}}</td>
                  <td>
                    <a href="#" class>
                      <i class="fa fa-edit blue"></i>
                    </a>
                    <a href="#" class>
                      <i class="fa fa-trash red"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>

    <!-- Modal -->
    <div
      class="modal fade"
      id="novoUsuario"
      tabindex="-1"
      role="dialog"
      aria-labelledby="novoUsuarioLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="novoUsuarioLabel">Adicionar Novo Usuário</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="criarUsuario">
            <div class="modal-body">
              <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" class="form-control" name="name" id="name" v-model="fields.name" />
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
                <label for="tipo">Tipo</label>
                <select class="custom-select" id="tipo" name="tipo" v-model="fields.tipo">
                  <option selected>Selecione...</option>
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
                <div v-if="errors && errors.password" class="text-danger">{{ errors.password[0] }}</div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">
                Close
                <i class="fas fa-times"></i>
              </button>
              <button type="submit" class="btn btn-primary">
                Criar Usuário
                <i class="fas fa-user-plus fa fw"></i>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  created() {
    this.$Progress.start();
    this.carregarUsuarios();
    
    Toast.fire({
      icon: 'success',
      title: 'Lista de Usuários Carregada com Sucesso !'
    })

    this.$Progress.finish();


  },
  data() {
    return {
      fields: {},
      users: {},
      errors: {},
      success: false,
      loaded: true,
      action: "/api/user"
    };
  },
  methods: {
    carregarUsuarios() {
      axios
        .get("api/user")
        .then(({ data }) => (this.users = data.data))
        .catch(error => {});
    },

    criarUsuario() {
      if (this.loaded) {
        this.$Progress.start();

        this.loaded = false;
        this.success = false;
        this.errors = {};
        axios
          .post(this.action, this.fields)
          .then(response => {
            this.fields = {}; //Clear input fields.
            this.loaded = true;
            this.success = true;
            $('#novoUsuario').modal('hide');
            Toast.fire({
              icon: 'success',
              title: 'Usuário Criado com Sucesso !'
            })

            this.$Progress.finish();
            this.carregarUsuarios();
      
          })
          .catch(error => {
            this.loaded = true;
            if (error.response.status === 422) {
              this.errors = error.response.data.errors || {};
            }
            Toast.fire({
              icon: 'error',
              title: 'Ops houve um problema no formulário, tente novamente!'
            })

            this.$Progress.fail()

          });

      }
    }
  }
};
</script>
