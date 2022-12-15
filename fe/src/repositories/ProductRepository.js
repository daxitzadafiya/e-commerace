import Client from "./Clients/AxiosClient";
const addProduct = "products";
const config = {
  headers: { "content-type": "multipart/form-data" },
};
export default {
  index() {
    return Client.get(`${addProduct}`);
  },

  add(data) {
    return Client.post(`${addProduct}`, data, config);
  },

  delete(id) {
    return Client.delete(`${addProduct}/${id}`);
  },
  show(id){
    return Client.get(`${addProduct}/${id}`);
  },
  update(id,data){
        return Client.put(`${addProduct}/${id}`,data,config);
  }
};
