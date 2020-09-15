<template>
  <div class="container">
    <div class="row mt-5">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <b-form-group label="List Of Users" label-cols-lg="2"></b-form-group>
            <b-form-group label="Search:" label-cols-lg="1">
              <input
                class="form-control form-control-navbar"
                @keyup="searchit"
                v-model="search"
                type="search"
                placeholder="Search"
                aria-label="Search"
              />
            </b-form-group>

            <div class="card-tools">
              <button class="btn btn-success" @click="newModal">
                Add new User
                <i class="fas fa-user-plus fa-fw"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Type</th>
                  <th>Created At</th>
                  <th>Updated At</th>
                  <th>Modify</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="user in users.data" :key="user.id">
                  <td>{{ user.name | upText}}</td>
                  <td>{{ user.email }}</td>
                  <td>{{ user.tipo | upText}}</td>
                  <td>{{ user.created_at | formatData}}</td>
                  <td>{{ user.updated_at | formatData}}</td>
                  <td>
                    <a href="#" @click="editModal(user)">
                      <i class="fa fa-edit blue"></i>
                    </a>
                    <a href="#" @click="deleteUser(user.id)">
                      <i class="fa fa-trash red"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <pagination :data="users" @pagination-change-page="getResults" :limit="1">
              <span slot="prev-nav">&lt; Previous</span>
              <span slot="next-nav">Next &gt;</span>
            </pagination>
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>

    <!-- Modal -->
    <div
      class="modal fade"
      id="newUser"
      tabindex="-1"
      role="dialog"
      aria-labelledby="newUserLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 v-if="editMode" class="modal-title" id="newUserLabel">Update User</h5>
            <h5 v-else class="modal-title" id="newUserLabel">Add New User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editMode ? updateUser(): createUser()">
            <div class="modal-body">
              <div class="form-group">
                <label for="name">Name</label>
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
                <label for="tipo">Type</label>
                <select class="custom-select" id="tipo" name="tipo" v-model="fields.tipo">
                  <option value selected>Selecione...</option>
                  <option value="admin">Admin</option>
                  <option value="default">Default</option>
                </select>
                <div v-if="errors && errors.tipo" class="text-danger">{{ errors.tipo[0] }}</div>
              </div>

              <div class="form-group">
                <label for="password">Password</label>
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
                Cancel
                <i class="fas fa-times"></i>
              </button>
              <button v-if="editMode" type="submit" class="btn btn-success">
                Update User
                <i class="fas fa-user-edit"></i>
              </button>
              <button v-else type="submit" class="btn btn-success">
                Create User
                <i class="fas fa-user-plus"></i>
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
    Fire.$on("searching", () => {
      let query = this.search;
      axios
        .get("api/findUser?query=" + query)
        .then((data) => {
          console.log(data);
          this.users = data.data;
        })
        .catch(() => {});
    });
    this.$Progress.start();
    this.loadUsers();
  },

  data() {
    return {
      editMode: false,
      fields: [],
      users: {},
      errors: {},
      success: false,
      search: "",
      loaded: true,
      action: "/api/user",
    };
  },
  methods: {
    searchit: _.debounce(() => {
      Fire.$emit("searching");
    }, 1000),
    printme() {
      window.print();
    },
    getResults(page = 1) {
      axios.get("api/user?page=" + page).then((response) => {
        this.users = response.data;
      });
    },
    editModal(user) {
      this.loaded = true;
      this.errors = {};
      this.success = false;
      this.fields = {}; //Clear input fields.
      this.editMode = true;
      this.fields = { ...user };

      $("#newUser").modal("show");
    },
    newModal() {
      this.editMode = false;
      this.fields = {}; //Clear input fields.
      this.loaded = true;
      this.success = true;
      this.errors = {};
      $("#newUser").modal("show");
    },
    deleteUser(id) {
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
              .delete("api/user/" + id)
              .then((response) => {
                swal.fire("Deleted!", "User successfully deleted!", "success");
                this.loadUsers();
              })
              .catch((error) => {
                swal.fire(
                  "Falha!",
                  "Oops something went wrong try, again later",
                  "error"
                );
              });
          }
        });
    },
    loadUsers() {
      axios
        .get("api/user")
        .then(({ data }) => (this.users = data), this.$Progress.finish())
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: "Fail to load users!",
          }),
            this.$Progress.fail();
        });
    },

    createUser() {
      if (this.loaded) {
        this.$Progress.start();

        this.loaded = false;
        this.success = false;
        this.errors = {};
        axios
          .post(this.action, this.fields)
          .then((response) => {
            this.fields = {}; //Clear input fields.
            this.loaded = true;
            this.success = true;
            $("#newUser").modal("hide");
            Toast.fire({
              icon: "success",
              title: "User Updated Successfully!",
            });

            this.$Progress.finish();
            this.loadUsers();
          })
          .catch((error) => {
            this.loaded = true;
            if (error.response.status === 422) {
              this.errors = error.response.data.errors || {};
            }
            Toast.fire({
              icon: "error",
              title: "Oops something went wrong, try again later!",
            });

            this.$Progress.fail();
          });
      }
    },
    updateUser() {
      if (this.loaded) {
        this.$Progress.start();

        this.loaded = false;
        this.success = false;
        this.errors = {};
        axios
          .put("api/user/" + this.fields.id, this.fields)
          .then((response) => {
            this.fields = {}; //Clear input fields.
            this.loaded = true;
            this.success = true;
            $("#newUser").modal("hide");
            Toast.fire({
              icon: "success",
              title: "Usuário Atualizado com Sucesso !",
            });

            this.$Progress.finish();
            this.loadUsers();
          })
          .catch((error) => {
            this.loaded = true;
            this.success = false;
            if (error.response.status === 422) {
              this.errors = error.response.data.errors || {};
            }
            Toast.fire({
              icon: "error",
              title: "Ops Houve Um Problema No Formulário, Tente Novamente!",
            });

            this.$Progress.fail();
          });
      }
    },
  },
};
</script>
