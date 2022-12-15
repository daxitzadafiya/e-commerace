<template>
  <div class="form-signin">
    <div class="card">
      <div class="card-body">
        <form>
          <div class="mb-3">
            <label class="form-label" for="color">Color:</label> <br>
            <input
              type="text"
              class="form-control"
              id="color"
              v-model="form.color"
            />
          </div>
          <div class=" mb-3">
            <label class="form-label" for="product">Product:</label> <br> 
            <select class="custom-select form-control" id="product" v-model="form.product_id">
              <option v-for="item in products" :key="item.id" :value="item.id">
                {{ item.name }}
              </option>
            </select>
          </div>

          <div class=" mb-3">
            <label class="form-label" for="size" >Size:</label>
            <input
              type="text"
              class="form-control"
              id="size"
              v-model="form.size"
            />
          </div>

          <button class="btn btn-primary w-100" @click.prevent="addVariant">
            {{ id ? "Edit" : "Add" }}
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import Repository from "@/repositories/RepositoryFactory";
const ProductRepository = Repository.get("product");
const productVariantRepository = Repository.get("productVariant");

export default {
  name: "AddProductVariant",
  data() {
    return {
      form: this.initForm(),
      products: [],
    };
  },
  created() {
    this.id = this.$route.params.id;
    if (this.id) this.fetchVariant(this.id);

    this.fetchProduct();
  },
  methods: {
    fetchProduct() {
      ProductRepository.index()
        .then((response) => {
          if (response.status == 200);
          this.products = response.data.data.products;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    fetchVariant(id) {
      productVariantRepository
        .show(id)
        .then((response) => {
          let res = response.data.data.product_variant;
          this.form.color = res.color;
          this.form.product_id = res.product_id;
          this.form.size = res.size;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    addVariant() {
      let formdata = new FormData();
      formdata.append("color", this.form.color);
      formdata.append("product_id", this.form.product_id);
      formdata.append("size", this.form.size);

      if (this.id) {
        // let data={
        //     color:this.form.color,
        //     product_id:this.form.product_id,
        //     size:this.form.size
        // }
        productVariantRepository
          .update(this.id, formdata)
          .then((response) => {
            if (response.status == 200);
            this.$router.push("/variant");
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        productVariantRepository
          .add(formdata)
          .then((response) => {
            if (response.status == 200);
            this.$router.push("/variant");
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
    initForm() {
      return {
        color: null,
        product_id: null,
        size: null,
      };
    },
  },
};
</script>

<style scoped>  
</style>