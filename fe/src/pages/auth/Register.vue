<template>
  <div class="form-signin">
    <div class="card">
      <div class="card-body">
        <form @submit.prevent="register">
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input
              type="text"
              class="form-control"
              id="name"
              v-model="form.name"
            />
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input
              type="email"
              class="form-control"
              id="email"
              v-model="form.email"
            />
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input
              type="password"
              class="form-control"
              id="password"
              v-model="form.password"
            />
          </div>
          <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import Repository from "@/repositories/RepositoryFactory";
const AuthRepository = Repository.get("auth");

export default {
  name: "Register",
  data() {
    return {
      form: this.initForm(),
    };
  },
  methods: {
    register() {
      AuthRepository.register(this.form)
        .then((response) => {
          this.form = this.initForm();

          localStorage.setItem("token", response.data.access_token);
          this.$store.dispatch("user", response.data);
          this.$router.push("/");
        })
        .catch((error) => {
          console.log(error);
        });
    },

    initForm() {
      return {
        name: null,
        email: null,
        password: null,
      };
    },
  },
};
</script>

<style scoped>
</style>