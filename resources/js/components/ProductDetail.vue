<template>
  <div>
    <v-container class="grey lighten-5">
      <b-form @submit.prevent="save">
        <v-row>
          <v-col>
            <v-card class="d-inline-block mx-auto">
              <v-app-bar dark color="pink">
                <v-toolbar-title>Product Details</v-toolbar-title>

                <v-spacer></v-spacer>
              </v-app-bar>

              <v-container>
                <v-row dense>
                  <v-col cols="12">
                    <v-card class="mx-auto" max-width="700">
                      <v-card-actions>
                        <v-btn color="#1F7087" text>Image</v-btn>
                        <input type="file" @change="onFileChange" />
                      </v-card-actions>
                      <v-img
                        class="white--text align-end"
                        aspect-ratio="1.4"
                        contain
                        :src="this.product_data.image"
                      ></v-img>
                    </v-card>
                  </v-col>
                  <v-col cols="12">
                    <v-card color="#1F7087" dark>
                      <v-card-title class="headline">Resume</v-card-title>

                      <v-card-subtitle>
                        <div>
                          <b-form-textarea
                            id="textarea"
                            v-model="product_data.resume"
                            placeholder="Enter something..."
                            rows="3"
                            max-rows="6"
                          ></b-form-textarea>
                        </div>
                      </v-card-subtitle>
                    </v-card>
                  </v-col>

                  <v-col cols="12">
                    <v-card>
                      <v-card-title class="headline">Description</v-card-title>

                      <v-card-text>
                        <ckeditor
                          :editor="editor"
                          v-model="product_data.description"
                          :config="editorConfig"
                        ></ckeditor>
                      </v-card-text>
                    </v-card>
                  </v-col>
                </v-row>
              </v-container>
            </v-card>
          </v-col>
          <v-col>
            <div class="form-group">
              <label for="ref">Reference</label>
              <input
                type="text"
                class="form-control"
                name="ref"
                id="ref"
                v-model="product_data.ref"
              />
              <div v-if="errors && errors.ref" class="text-danger">{{ errors.ref[0] }}</div>
            </div>

            <div class="form-group">
              <label for="quantity">Quantity</label>
              <input
                type="number"
                class="form-control"
                name="quantity"
                id="quantity"
                v-model="product_data.quantity"
              />
              <div v-if="errors && errors.quantity" class="text-danger">{{ errors.quantity[0] }}</div>
            </div>

            <div class="form-group">
              <label for="price_ht">Price</label>
              <b-form-row>
                <b-col>
                  HT
                  <b-input-group size="sm" append="€">
                    <b-form-input
                      type="text"
                      class="form-control"
                      name="price_ht"
                      id="price_ht"
                      v-model="product_data.price_ht"
                    ></b-form-input>
                  </b-input-group>
                  <div v-if="errors && errors.price_ht" class="text-danger">{{ errors.price_ht[0] }}</div>
                </b-col>
                <b-col>
                  TTC
                  <b-input-group size="sm" append="€">
                    <b-form-input
                      type="text"
                      class="form-control"
                      name="price_ttc"
                      id="price_ttc"
                      v-model="product_data.price_ttc"
                    ></b-form-input>
                  </b-input-group>
                  <div
                    v-if="errors && errors.price_ttc"
                    class="text-danger"
                  >{{ errors.price_ttc[0] }}</div>
                </b-col>
              </b-form-row>
            </div>

            <div class="form-group">
              <label for="category">Categories</label>
              <b-form-row>
                <b-col>
                  <treeselect
                    id="category"
                    name="category"
                    :autoLoadRootOptions="true"
                    v-model="value"
                    value-consists-of="ALL_WITH_INDETERMINATE"
                    :multiple="false"
                    :options="options"
                  />
                </b-col>
              </b-form-row>
            </div>

            <div class="form-group">
              <label for="active">Active ?</label>
              <b-form-row>
                <b-col>
                  <b-form-checkbox
                    id="active"
                    v-model="active"
                    name="active"
                    :button-variant="variant"
                    button
                  >{{ active ? 'Yes' : 'No' }}</b-form-checkbox>
                </b-col>
              </b-form-row>
            </div>

            <div class="form-group">
              <b-button type="submit" pill variant="success">Save</b-button>
            </div>
          </v-col>
        </v-row>
      </b-form>
    </v-container>
  </div>
</template>




<script>
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import "@ckeditor/ckeditor5-build-classic/build/translations/pt";
import Treeselect from "@riophae/vue-treeselect";
// import the styles
import "@riophae/vue-treeselect/dist/vue-treeselect.css";
export default {
  components: { Treeselect },

  data() {
    return {
      value: [],
      options: [
        {
          id: "Esop",
          label: "Eshop",
          children: [
            {
              id: 1,
              label: "Clothes",
              children: [
                {
                  id: "Tshirt",
                  label: "Tshirt",
                },
                {
                  id: "Tops",
                  label: "Tops",
                },
                {
                  id: "Sweaters",
                  label: "Sweaters",
                },
                {
                  id: "Dresses",
                  label: "Dresses",
                },
                {
                  id: "Shoes",
                  label: "Shoes",
                },
              ],
            },
            {
              id: 2,
              label: "Accessory",
              children: [
                {
                  id: "Jewels",
                  label: "Jewels",
                },
                {
                  id: "Bags",
                  label: "Bags",
                },
              ],
            },
          ],
        },
      ],
      variant: "",
      success: false,
      fields: [],
      errors: {},
      active: null,
      file: null,
      loaded: true,
      editor: ClassicEditor,
      editorConfig: {
        language: "pt",
      },
      product_data: {
        description: "",
        resume: "",
      },
    };
  },

  watch: {
    // sempre que a pergunta mudar, essa função será executada
    active: function (newvalue, oldvalue) {
      newvalue == true ? (this.variant = "success") : (this.variant = "danger");
    },
  },
  methods: {
    onFileChange(e) {
      const file = e.target.files[0];
      this.file = file;
      this.product_data.image = URL.createObjectURL(file);
    },
    save() {
      this.$Progress.start();
      let file = this.file;
      let reader = new FileReader();
      let limit = 1024 * 1024 * 2;

      if (file.size > limit) {
        swal.fire({
          icon: "error",
          title: "Size over allowed!",
        });
        return false;
      }
      reader.onloadend = (file) => {
        this.product_data.arquivo = reader.result;
      };
      reader.readAsDataURL(file);
      console.log(reader);
    },
  },

  beforeMount() {
    this.product_data = { ...this.$route.params.product };
    this.value.push(this.product_data.category);
    if (this.product_data.active == "Yes") {
      this.variant = "success";
      this.active = true;
    } else {
      this.variant = "danger";
      this.active = false;
    }
  },
};
</script>

<style>
#preview {
  display: flex;
  justify-content: center;
  align-items: center;
}

#preview img {
  max-width: 100%;
  max-height: 500px;
}
</style>