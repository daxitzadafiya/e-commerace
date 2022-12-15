<template>
  <div class="form-signin">
    <div class="card">
      <div class="card-body">
        <form>
          <div class="mb-3">
            <label for="productName" class="form-label">Product name</label>
            <input
              type="text"
              class="form-control"
              id="productName"
              v-model="form.productName"
            />
          </div>
          <div class="mb-3">
            <input type="file" @change="SelectFile" />
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input
              type="text"
              class="form-control"
              id="description"
              v-model="form.description"
            />
          </div>
          <div class="mb-4">
            <label for="price" class="form-label">Price</label>
            <input
              type="number"
              class="form-control "
              id="price"
              v-model="form.price"
            />
          </div>
          <button class="btn btn-primary w-100 " @click.prevent="addProduct">
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

export default {
  name: "AddProduct",
  data() {
    return {
      form: this.initForm(),
      selectedFile: [],
      id: "",
    };
  },
  created() {
    this.id = this.$route.params.id;
    if (this.id) this.fetchData(this.id);
  },
  methods: {
    fetchData(id) {
      ProductRepository.show(id)
        .then((response) => {
          let res = response.data.data.product;
          this.form.productName = res.name;
          this.form.description = res.description;
          this.form.price = res.price;
          this.selectedFile = res.image;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    addProduct() {
      let formdata = new FormData();
      formdata.append("name", this.form.productName);
      formdata.append("description", this.form.description);
      formdata.append("price", this.form.price);
      formdata.append("image", this.selectedFile);
      // let data={
      //   name:this.form.productName,
      //   description:this.form.description,
      //   price:this.form.price,
      //   image:formdata.get('image')
      // }

      if (this.id) {
        ProductRepository.update(this.id, formdata)
          .then((response) => {
            if (response.status == 200);
            this.$router.push("/product");
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        ProductRepository.add(formdata)
          .then((response) => {
            if (response.status == 200);
            this.$router.push("/product");
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },

    SelectFile(e) {
      this.selectedFile = e.target.files[0];
    },

    initForm() {
      return {
        productName: null,
        description: null,
        price: null,
        file: null,
      };
    },
  },
};
</script>

<style>
.form-signin {
  width: 100%;
  max-width: 400px;
  padding: 15px;
  margin: 0 auto 0;
  display: flex;
  align-items: center;
  height: 100vh;
}
.card {
  border: 0;
  padding: 20px;
  box-shadow: 0 0 10px rgb(197 197 197 / 50%);
  border-radius: 11px;
}
.form-label {
  font-size: 18px;
  font-weight: 500;
}
.card-body{
  padding: 0;
}
</style>