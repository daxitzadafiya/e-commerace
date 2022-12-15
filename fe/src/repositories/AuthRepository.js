import Client from "./Clients/AxiosClient";
const login = "/login";
const register = "/register";

export default {
  login(data) {
    return Client.post(`${login}`,data);
  },

  register(data) {
    return Client.post(`${register}`,data);
  },
};
