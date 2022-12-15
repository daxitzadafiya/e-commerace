import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

const store = new Vuex.Store({
  state: {
    user: {
      name: "",
    },
    isLoggedIn: false,
  },

  getters: {
    user(state) {
      return state.user;
    },
    isLoggedIn(state) {
      return state.isLoggedIn;
    },
  },

  actions: {
    user(context, data) {
      context.commit("user", data);
    },
  },

  mutations: {
    user(state, data) {
      state.user = data;
      if (data) state.isLoggedIn = true;
    },
  },
});

export default store;
