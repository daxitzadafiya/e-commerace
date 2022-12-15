import Client from "./Clients/AxiosClient";
const productVariant = "product-variants";
const config = {
  headers: { "content-type": "multipart/form-data" },
};
export default {
  index() {
    return Client.get(`${productVariant}`);
  },

  add(data) {
    return Client.post(`${productVariant}`, data, config);
  },

  delete(id) {
    return Client.delete(`${productVariant}/${id}`);
  },
  show(id) {
    return Client.get(`${productVariant}/${id}`);
  },
  update(id, data) {
    return Client.put(`${productVariant}/${id}`, data, config);
  },
};
