import axios from "axios";

const API_URL = "http://localhost:8000";

export const sendMessage = async (message, model = 'gpt-3.5-turbo') => {
    try {
        const response = await axios.post(API_URL, { 
            message,
            model 
        });
        return response.data;
    } catch (error) {
        throw error.response?.data || error.message;
    }
};