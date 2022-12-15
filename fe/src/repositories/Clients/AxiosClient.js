import axios from "axios";
import config from "../../../config.js";
axios.defaults.baseURL = config.BASE_URL;
axios.defaults.headers.common["Authorization"] = `Bearer ${localStorage.getItem(
  "token"
)}`;

export default axios;
