
<template>   
    <nav class="bg-gray-100 py-3  w-100 px-8 md:px-auto">
        <div class="md:h-16 h-28 mx-auto md:px-4 container flex items-center justify-between flex-wrap md:flex-nowrap">
            <div class="text-cohrosPrimary md:order-1">                
                <img class="w-auto h-16" :src="LogoCohros" alt="Logo Cohros" srcset="">                
            </div>
            <div class="text-gray-500 order-3 w-full md:w-auto md:order-2">
                <ul v-if="useAuthStore().user_information.isLoggedIn === true" class="flex font-semibold justify-between">
                    <RouterLink class="md:px-4 md:py-2 text-cohrosPrimary" to="/agenda">Lista de contatos</RouterLink>
                    <RouterLink class="md:px-4 md:py-2 text-cohrosPrimary" to="/contact/create">Adicionar Contato</RouterLink>
                </ul>               
            </div>
            <div v-if="useAuthStore().user_information.isLoggedIn === false" class="order-2 md:order-3">
                <RouterLink to="/" class="px-4 py-2 bg-cohrosPrimary hover:bg-green-400 text-gray-50 rounded-xl flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    <span>Login</span>
                </RouterLink>
            </div>
            <div v-else class="order-2 md:order-3">
                <button @click="handleLogout" class="px-4 py-2 bg-cohrosPrimary hover:bg-green-400 text-gray-50 rounded-xl flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    <span>Logout</span>
                </button>
            </div>
        </div>
    </nav>   
</template>
    
    
<script setup>
import { RouterLink,useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';
import Swal from 'sweetalert2';
import { onMounted } from 'vue';
import LogoCohros from '@/assets/images/logocohros.png';




const authStore = useAuthStore();

const router = useRouter();

const handleLogout = () => {
    authStore.logout().then((data) => {

        authStore.removeUserToken();      
        
        Swal.fire({
            toast: true,
            icon: 'success',
            title: `Deslogado`,
            animation: true,
            position: 'center',
            showConfirmButton: false,
            timer: 1000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        }).then(() => {
            router.push({ name: 'login' })
        });
      

    }).catch((err) => {
       
        Swal.fire({
            toast: true,
            icon: 'error',
            title: `${err.message}`,
            animation: true,
            position: 'center',
            showConfirmButton: false,
            timer: 1000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

    })
};


</script>
