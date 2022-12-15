<template>
  <div class="form-signin">
    <div class="card">
      <div class="card-body">
        <form @submit.prevent="login">
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
          <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import Repository from "@/repositories/RepositoryFactory";
const AuthRepository = Repository.get("auth");

export default {
  name: "Login",
  data() {
    return {
      form: this.initForm(),
    };
  },

  methods: {
    login() {

      AuthRepository.login(this.form)
        .then((response) => {
          localStorage.setItem("token", response.data.data.authorization.token);
          this.$store.dispatch("user", response.data.data.user);
          this.$router.push("/");
        })
        .catch((error) => {
          console.log(error);
        });
    },

    initForm() {
      return {
        email: null,
        password: null,
      };
    },
  },
};
</script>

<style scoped>
</style>