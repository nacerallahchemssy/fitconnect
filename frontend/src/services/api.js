import axios from "axios";

const api = axios.create({
  baseURL: "http://localhost/fitconnect/backend/api/",
});

export default api;
