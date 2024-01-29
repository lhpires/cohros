<template>
    <section class="container mx-auto">

        <div class="w-full my-20 space-y-7 sm:space-y-0">
            <h4 class="text-cohrosPrimary text-4xl font-semibold text-center md:text-left">Lista de contatos</h4>

            <div class="text-right flex justify-end">
                <RouterLink :to="{ name: 'contact.create' }" class="px-4 py-2 bg-cohrosPrimary hover:bg-indigo-600 text-gray-50 rounded-xl flex items-center gap-2 w-fit">                
                    Adicionar Contato
                </RouterLink>
            </div>
         

        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            #ID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            NOME
                        </th>
                        <th scope="col" class="px-6 py-3">
                            E-MAIL
                        </th>
                        <th scope="col" class="px-6 py-3">
                            ENDEREÇO
                        </th>
                        <th scope="col" class="px-6 py-3">
                            AÇÕES
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="contact in contactStore.state.contacts" :key="contact.id" class="bg-white border-b">
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ contact.id }}
                        </td>
                        <td class="px-6 py-4">
                            {{ contact.name }}

                        </td>
                        <td class="px-6 py-4">
                            {{ contact.email }}

                        </td>
                        <td class="px-6 py-4">
                            {{ contact.address }}
                        </td>
                        <td class="flex items-center px-6 py-4 space-x-3">
                            <button @click="editContactModal(contact.id)" class="font-medium text-cohrosPrimary dark:text-cohrosPrimary hover:underline"><Pencil :stroke-width="1.75" /></button>
                            <button @click="deleteContact(contact.id)" class="font-medium text-red-700 dark:text-cohrosPrimary hover:underline"><Trash :stroke-width="1.75" /></button>
                        </td>
                    </tr>              
                </tbody>
            </table>
        </div>

        <transition>
            <Modal v-if="isEidtModalVisible" @close-modal="onToggleEditModal">
                <template #title>{{contactStore.state.contact.name}}</template>
                <template #actions>
                    <button @click="editSubmitContact" class="focus:outline-none text-white bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg dark:bg-green-600 dark:focus:ring-green-800 hover:bg-green-800 dark:hover:bg-green-700 text-sm px-4 py-2" href="">
                        <span class="">
                            Editar
                        </span>
                    </button>
                </template>

                <div class="mb-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <label for="contactName" class="block text-sm font-medium leading-6 text-gray-900">Nome</label>
                        <div>
                            <input autocomplete="off" type="text" name="contactName" id="contactName" v-model="contactStore.state.contact.name" class="input-library w-full">
                        </div>
                    </div>
                    <div class="sm:col-span-6">
                        <label for="contactEmail" class="block text-sm font-medium leading-6 text-gray-900">E-mail</label>
                        <div>
                            <input autocomplete="off" type="text" name="contactEmail" id="contactEmail" v-model="contactStore.state.contact.email" class="input-library w-full">
                        </div>
                    </div>
                    <div class="sm:col-span-12">
                        <label for="contactAddress" class="block text-sm font-medium leading-6 text-gray-900">Endereço</label>
                        <div>
                            <input autocomplete="off" type="text" name="contactAddress" id="contactAddress" v-model="contactStore.state.contact.address" class="input-library w-full">
                        </div>
                    </div>
                </div>
                <div class="space-y-4">
                    <h4>Números de contato</h4>
                    <div class="flex items-center gap-2"  v-for="(number,idx) in contactStore.state.contact.phone_numbers" :key="idx" >                        
                        <input autocomplete="off" v-model="contactStore.state.contact.phone_numbers[idx].number" class="input-library w-full"/>
                        <Trash2 @click="deleteNumber(contactStore.state.contact.phone_numbers[idx].id)" class="text-red-400 cursor-pointer" />
                    </div>
                    <div class="flex justify-center text-cohrosPrimary">
                        <BadgePlus @click="addNumber(contactStore.state.contact.id)" class="mt-4 cursor-pointer" />
                    </div>
                </div>                
            </Modal>
        </transition>
    </section>
   
</template>

<script setup>
import { onMounted,ref,reactive, onUpdated } from 'vue';
import { RouterLink } from 'vue-router'

import { contactsStore } from "../../stores/contacts";
import { Pencil,Trash } from 'lucide-vue-next';
import Modal from '../reusable/modalComponent.vue';
import Swal from 'sweetalert2';
import {BadgePlus,Trash2} from 'lucide-vue-next';
import Axios from '../../services/Axios';



const contactStore = contactsStore();

const isEidtModalVisible = ref(false);

const onToggleEditModal = (toggle = null) => {

    switch (toggle) {
        case null:
            isEidtModalVisible.value = !isEidtModalVisible.value;

            if(!isEidtModalVisible.value) contactStore.state.contact = {};
            
            break;
        case 1:
            isEidtModalVisible.value = true;
        break;
        default:
            isEidtModalVisible.value = false;
            contactStore.state.contact = {};            
            break;
    }
   
}

const editContactModal = (id) => {
    contactStore.getContact(id);
    onToggleEditModal();
}

const deleteContact = (id) => {


    Swal.fire({
        title: `Tem certeza que deseja excluir esse contato?`,
        showDenyButton: true,     
        denyButtonText: "Não",
        confirmButtonText: "Sim"
    }).then((result) => {
        if(result.isConfirmed === true){            
          
            contactStore.deleteContact(id).then((msg) => {

                Swal.fire({
                    title: `${msg.message}`,
                    icon: "success"
                }).then(() => {
                    contactStore.getContacts();
                    contactStore.state.contact = {};
                    onToggleEditModal(false);
                });

                }).catch((error) => {
                    Swal.fire({
                        title: `${error.message}`,
                        icon: "error"
                    });
                });
        }
    });

 
}


const editSubmitContact = () => {

    const form = {
        "name": contactStore.state.contact.name,        
        "email": contactStore.state.contact.email,       
        "address": contactStore.state.contact.address,       
        "phone_numbers": contactStore.state.contact.phone_numbers,        
    }


    contactStore.updateContact(contactStore.state.contact.id,form)
    .then((msg) => {
        Swal.fire({
            title: `${msg.message}`,
            icon: "success"
        }).then(() => {
            contactStore.getContacts();
            contactStore.state.contact = {};
            onToggleEditModal(false);
        });
        
    }).catch((error) => {
        Swal.fire({
            title: `${error.message}`,
            icon: "error"
        });
    });
        
    


}

const addNumber = (id) => {
    contactStore.state.contact.phone_numbers.push({
        "id": null,
        "number": ""
    });
}

const deleteNumber = async (id) => {

    try {
        const { data } = await Axios.delete(`/phoneNumbers/${id}`);

        Swal.fire({
            title: `${data.message}`,
            icon: "success"
        }).then(() => {
            contactStore.getContact(contactStore.state.contact.id);
        });


    } catch (ex) {
        const msg = (ex.response.data.error) ? ex.response.data.error : ex.response.data.message;
        Swal.fire({
            title: `${msg}`,
            icon: "error"
        });
    }


   
}

onMounted(() => {
    contactStore.getContacts();
});

</script>

<style scoped>


.fade-enter,
.fade-leave-to {
  opacity: 0;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 500ms ease-out;
}
</style>