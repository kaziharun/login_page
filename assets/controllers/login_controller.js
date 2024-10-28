import { Controller } from '@hotwired/stimulus';
import axios from 'axios';


const API_ENDPOINT = '/api/login';
const SUCCESS_MESSAGE_TEMPLATE = (message) => `<div class="alert alert-success">${message}</div>`;
const ERROR_MESSAGE_TEMPLATE = (message) => `<div class="alert alert-danger">${message}</div>`;
const GENERIC_ERROR_MESSAGE = "An error occurred. Please try again.";

export default class extends Controller {
    connect() {
        this.element.addEventListener("submit", this.handleSubmit.bind(this));
    }

    async handleSubmit(event) {
        event.preventDefault(); // Prevent default form submission
        const data = this.prepareFormData();

        console.log("Data being sent:", data);

        try {
            const result = await this.submitData(data);
            this.handleResponse(result);
        } catch (error) {
            this.handleError(error);
        }
    }


    prepareFormData() {
        const formData = new FormData(this.element);
        return Object.fromEntries(formData.entries());
    }


    async submitData(data) {
        const response = await axios.post(API_ENDPOINT, data, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        });
        return response.data; // Return the response data directly
    }

    handleResponse(result) {
        console.log("Response received:", result);
        const messageElement = document.getElementById("loginResponse");

        if (result.status === "ok") {
            messageElement.innerHTML = SUCCESS_MESSAGE_TEMPLATE(result.message);
        } else {
            messageElement.innerHTML = ERROR_MESSAGE_TEMPLATE(result.message);
        }
    }

    handleError(error) {
        console.error("Error:", error);
        document.getElementById("loginResponse").innerHTML = ERROR_MESSAGE_TEMPLATE(GENERIC_ERROR_MESSAGE);
    }
}