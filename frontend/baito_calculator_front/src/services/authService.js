import { L } from 'vue-router/dist/index-DFCq6eJK';
import api from './api';

export const authService = {
    async login(credentials){
        const response =  await api.post('/login', credentials);
        if(response.data.token){
            localStorage.setItem('auth_token', response.data.token);
            localStorage.setItem('user', JSON.stringify(response.data.user));
        }
        return response.data;
    },
    async register(userData){
        const response = await api.post('/register', userData);
        if (response.data.token){
            localStorage.setItem('auth_token', response.data.token);
            localStorage.setItem('user', JSON.stringify(response.data.user));
        }
        return response.data;
    },

    async logout(){
        try{
            await api.post('/logout');
        }
        finally {
            localStorage.removeItem('auth_token');
            localStorage.removeItem('user');
        }
    },

    getUser(){
        const userJson = localStorage.getItem('user');
        return userJson ? JSON.parse(userJson) : null;
    },
    getToken(){
        return localStorage.getItem('auth_token');
    },

    isAuthenticated(){
        return !! this.getToken();
    }




}