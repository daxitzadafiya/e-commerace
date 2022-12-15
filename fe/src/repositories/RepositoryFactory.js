import AuthRepository from "./AuthRepository";
import ProductRepository from "./ProductRepository";
import ProductVariantRepository from "./ProductVariantRepository";

const repositories = {
  auth: AuthRepository,
  product: ProductRepository,
  productVariant: ProductVariantRepository,
};
export default {
  get: (name) => repositories[name],
};
