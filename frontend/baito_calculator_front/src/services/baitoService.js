import api from './api';

export const baitoService = {
    async getAllBaitos(){
        const response = api.get('/baitos');
        return response.data;
    },

    async getBaito(id){
        const response = await api.get(`/baitos/${id}`);
        return response.data;
    },

    async createBaito(data){
        const response = await api.post('/baitos', data);
        return response.data;
    },

    async updateBaito(id,data){
        const response = await api.patch(`/baitos/${id}`, data);
        return response.data;
    },

    async deleteBaito(id){
        await api.delete(`/baitos/${id}`);
    },

    // async getBaitosPaginated(page = 1)
};