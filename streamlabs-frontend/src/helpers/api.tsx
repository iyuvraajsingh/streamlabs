// @ts-nocheck

import axios, { AxiosInstance, AxiosRequestConfig } from 'axios';

const API_URL: string =
  process.env.REACT_APP_API || 'http://localhost:8000/api';

const api: AxiosInstance = axios.create({
  baseURL: API_URL,
});

const setBearerToken = (
  config: AxiosRequestConfig,
  token?: string
): AxiosRequestConfig => {
  if (token) {
    config.headers = {
      ...config.headers,
      Authorization: `Bearer ${token}`,
    };
  }
  return config;
};

export const get = (
  url: string,
  token?: string,
  config?: AxiosRequestConfig
) => {
  return api.get(url, setBearerToken(config || {}, token));
};

export const post = (
  url: string,
  data?: any,
  token?: string,
  config?: AxiosRequestConfig
) => {
  return api.post(url, data, setBearerToken(config || {}, token));
};

export const put = (
  url: string,
  data?: any,
  token?: string,
  config?: AxiosRequestConfig
) => {
  return api.put(url, data, setBearerToken(config || {}, token));
};

export default api;
