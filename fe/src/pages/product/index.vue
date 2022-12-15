<template>
  <div class="mt-5 table-responsive">
    <div v-if="products.length">
      <div>
        <router-link :to="{ name: 'AddProduct' }"
          ><button class="btn-primary">Create new</button></router-link
        >
      </div>

      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">name</th>
            <th scope="col">Description</th>
            <th scope="col">Price</th>
            <th scope="col">Image</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody v-for="(product, index) in products" :key="index">
          <tr>
            <td>{{ index + 1 }}</td>
            <td>{{ product.name }}</td>
            <td>{{ product.description }}</td>
            <td>{{ product.price }}</td>
            <td>
              <img :src="product.image" alt="" width="50px" height="50px" />
            </td>
            <td>
              <div class="d-flex align-items-center">
                <button
                  class="btn btn-danger me-3"
                  @click="deleteProduct(product.id)"
                >
                  Delete
                </button>
                <button
                  class="btn btn-success"
                  @click="updateProduct(product.id)"
                >
                  update
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div v-else>
      <p>Table is empty</p>

      <router-link :to="{ name: 'AddProduct' }"
        ><button class="btn-primary">Create new</button></router-link
      >
    </div>
  </div>
</template>


<script>
import Repository from "@/repositories/RepositoryFactory";
const ProductRepository = Repository.get("product");

export default {
  name: "product",

  data() {
    return {
      products: [],
    };
  },

  created() {
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

    deleteProduct(id) {
      ProductRepository.delete(id)
        .then((response) => {
          if (response.status == 200);
          this.fetchProduct();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    updateProduct(id) {
      this.$router.push(`/product/${id}`);

      // ProductRepository.update(id,data)
    },
  },
};
</script>
<style >
.table tbody td{
  padding: 20px;
  font-size: 20px;
}
.table thead th{
  text-align: left;
  font-size: 20px;
  padding: 20px;
}
</style>