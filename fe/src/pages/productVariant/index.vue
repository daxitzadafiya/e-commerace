<template>
  <div class="mt-5">
    <div v-if="productVariant.length">
      <div>
        <router-link :to="{ name: 'AddVariant' }"
          ><button class="btn-primary mb-3">
            Create new variant
          </button></router-link
        >
      </div>

      <div class="row">
        <div
          body
          v-for="(product, index) in productVariant"
          :key="index"
          class="col-lg-4 mb-3"
        >
          <div class="card_block">
            <div class="card_img">
              <img
                :src="`http://127.0.0.1:8000/storage/${product.image}`"
                alt=""
              />
            </div>
            <div class="card_content">
              <h2>{{ product.name }}</h2>
              <p>{{ product.description }}</p>
              <div class="card_price">
                <h3>$ {{ product.price }}</h3>
                <div class="d-flex mb-4">
                  <h6><span> Color : </span> {{ product.color }}</h6>
                  <h6 class="ms-4"><span> Size : </span> {{ product.size }}</h6>
                </div>
              </div>
              <button class="btn btn-dark add_cart_btn btn-xl">Add Cart</button>
              <!-- <div class="d-flex justify-content-between">
                <button
                  class="btn btn-danger btn-lg"
                  @click="deleteProduct(product.id)"
                >
                  Delete
                </button>
                <button
                  class="btn btn-success btn-lg"
                  @click="updateProduct(product.id)"
                >
                  update
                </button>
              </div> -->
            </div>
          </div>
        </div>
      </div>

      <!-- <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <th scope="col">Image</th>
            <th scope="col">Price</th>
            <th scope="col">Color</th>
            <th scope="col">Size</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody v-for="(product, index) in productVariant" :key="index">
          <tr>
            <th scope="row">{{ index + 1 }}</th>
            <td>{{ product.name }}</td>
            <td>{{ product.description }}</td>
            <td>
              <img
                :src="`http://127.0.0.1:8000/storage/${product.image}`"
                alt=""
                width="50px"
                height="50px"
              />
            </td>
            <td>{{ product.price }}</td>
            <td>{{ product.color }}</td>
            <td>{{ product.size }}</td>
            <td>
              <button class="btn-danger" @click="deleteProduct(product.id)">
                Delete
              </button>
              <button class="btn-success" @click="updateProduct(product.id)">
                update
              </button>
            </td>
          </tr>
        </tbody>
      </table> -->
    </div>
    <div v-else>
      <p>Table is empty</p>

      <router-link :to="{ name: 'AddVariant' }"
        ><button class="btn-primary">Create new variant</button></router-link
      >
    </div>
  </div>
</template>


<script>
import Repository from "@/repositories/RepositoryFactory";
const productVariantRepository = Repository.get("productVariant");

export default {
  name: "product",

  data() {
    return {
      productVariant: [],
    };
  },

  created() {
    this.fetchProduct();
  },

  methods: {
    fetchProduct() {
      productVariantRepository
        .index()
        .then((response) => {
          if (response.status == 200);
          this.productVariant = response.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    deleteProduct(id) {
      productVariantRepository
        .delete(id)
        .then((response) => {
          if (response.status == 200);
          this.fetchProduct();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    updateProduct(id) {
      this.$router.push(`/variant/${id}`);
    },
  },
};
</script>
<style >
.card_block {
  padding: 20px;
  height: 100%;
  box-shadow: 0 0 10px rgb(197 197 197 / 50%);
  border-radius: 11px;
}
.card_img img {
  width: 100%;
  height: auto;
  border-radius: 10px;
}
.card_content {
  padding: 15px 0 0 0;
}
.card_content h2 {
  font-size: 25px;
  margin-bottom: 5px;
  text-transform: capitalize;
}
.card_content p {
  display: block;
  display: -webkit-box;
  max-width: 100%;
  height: 77px;
  margin: 0 auto;
  font-size: 14px;
  line-height: 26px;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
  margin-bottom: 20px;
  font-size: 18px;
}
.card_price h6 span {
  font-weight: 800;
}
.card_price h6 {
  font-size: 20px;
  margin-bottom: 10px !important;
  font-weight: 400;
}
.card_price h3 {
  margin-bottom: 10px;
  font-size: 30px;
}
.add_cart_btn {
  width: 100%;
}

</style>