import { ref, reactive } from 'vue';
import { defineStore } from 'pinia';
import Axios from '../services/Axios';


export const contactsStore = defineStore('contacts', () => {
  
  const state = reactive({
    contacts: [],
    contact: {}
  });


  async function getContacts(){
    const { data } = await Axios.get('contacts');

    try {
        state.contacts = data.contacts;
        return data.contacts;
    } catch (ex) {
      return Promise.reject(ex.response.statusText)
    }
    console.log(data.contacts)
  }

  async function getContact(id){
    try {
      const { data } = await Axios.get(`contacts/${id}`);
      state.contact = data.contact;
      return data.contact;
    } catch (ex) {
      const error = { status: ex.response.status, message: ex.response.data.error }
      return Promise.reject(error)
    }
  }

  async function addContact(form){
    try {
        const { data } = await Axios.post(`contacts/`,form);
        return data;
    } catch (ex) {      
      const msg = (ex.response.data.error) ? ex.response.data.error : ex.response.data.message;
      const error = { status: ex.response.status, message: msg }
      return Promise.reject(error)
    }
  }

  async function updateContact(id,contact){
    try {
        const { data } = await Axios.put(`contacts/${id}`,contact);
        return data;
    } catch (ex) {
      const msg = (ex.response.data.error) ? ex.response.data.error : ex.response.data.message;
      const error = { status: ex.response.status, message: msg }
      return Promise.reject(error)
    }
  }

  async function deleteContact(id){
    try {
        const { data } = await Axios.delete(`contacts/${id}`);
        return data;
    } catch (ex) {
      const msg = (ex.response.data.error) ? ex.response.data.error : ex.response.data.message;
      const error = { status: ex.response.status, message: msg }
      return Promise.reject(error)
    }
  }



  return { state,getContacts,getContact,updateContact,deleteContact,addContact }
})
