<template>
    <section class="container mx-auto">        
        <div class="w-full my-20">
            <h4 class="text-cohrosPrimary text-4xl font-semibold text-center md:text-left">Cadastrar novo Contato</h4>
        </div>
        <div class="w-2/4 mx-auto">
            <form @submit.prevent="submitForm">
                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <label for="contactName" class="block text-sm font-medium leading-6 text-gray-900">Nome</label>
                        <div class="mt-2">
                        <input autocomplete="off" v-model="form.name" type="text" name="contactName" id="contactName" class="input-library">
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="contactEmail" class="block text-sm font-medium leading-6 text-gray-900">E-mail</label>
                        <div class="mt-2">
                        <input autocomplete="off" v-model="form.email" type="text" name="contactEmail" id="contactEmail" class="input-library">
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="contactAddress" class="block text-sm font-medium leading-6 text-gray-900">Endereço</label>
                        <div class="mt-2">
                            <input autocomplete="off" v-model="form.address" type="text" name="contactAddress" id="contactAddress" class="input-library">
                        </div>
                    </div>

                </div>
                <hr class="mt-10">
                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-12">                    

                    <div class="sm:col-span-12">
                        <label for="contactNumbers[]" class="block text-sm font-medium leading-6 text-gray-900 text-center">Número de contato</label>

                        <div v-for="(value,index) in form.phone_numbers" :key="index" class="mt-2">
                            <input autocomplete="off" v-model="value.number" type="text" name="contactAddress" id="contactAddress" class="input-library w-full md:w-1/2 md:mx-auto">
                        </div>                        
                    </div>

                   <div class="sm:col-span-12 text-cohrosPrimary">
                        <BadgePlus @click="addNumber()" class="block cursor-pointer w-full" />
                   </div>
                </div>
                <button type="submit" class="button-library mt-7">Atualizar</button>
            </form>
        </div>
    </section>
</template>

<script setup>
import { onMounted,reactive } from 'vue';
import { useRouter } from 'vue-router'
import { BadgePlus } from 'lucide-vue-next';
import { contactsStore } from '../../stores/contacts';
import Swal from 'sweetalert2';


const contactStore = contactsStore();
const router = useRouter()



const form = reactive({
    "name": "",
    "email": "",
    "address": "",
    "phone_numbers": [],
});


const submitForm = () => {    
    contactStore.addContact(form).then((msg) => {

        Swal.fire({
            title: `${msg.message}`,
            icon: "success"
        }).then(() => {
            router.push({ name: 'dashboard' })
        });


    }).catch((error) => {

        Swal.fire({
            title: `${error.message}`,
            icon: "error"
        });

    });
}

const addNumber = () => {
    form.phone_numbers.push({
        "id": null,
        "number": ""
    });
}

onMounted( () => {
    addNumber();
});
</script>