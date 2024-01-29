
<template>

<section class="grid grid-cols-1 grid-rows-1 md:grid-cols-2 justify-items-center h-screen">
    <aside class="hidden md:flex justify-center items-center bg-white">
        <picture class="max-w-md text-center">
            <img class="w-full" decoding="async" src="https://cohros.com.br/wp-content/uploads/2022/12/imagem-01-cohros-nv.jpg" alt="" data-lazy-srcset="https://cohros.com.br/wp-content/uploads/2022/12/imagem-01-cohros-nv.jpg 411w, https://cohros.com.br/wp-content/uploads/2022/12/imagem-01-cohros-nv-300x204.jpg 300w" data-lazy-sizes="(max-width: 411px) 100vw, 411px" data-lazy-src="https://cohros.com.br/wp-content/uploads/2022/12/imagem-01-cohros-nv.jpg" data-ll-status="loaded" sizes="(max-width: 411px) 100vw, 411px" srcset="https://cohros.com.br/wp-content/uploads/2022/12/imagem-01-cohros-nv.jpg 411w, https://cohros.com.br/wp-content/uploads/2022/12/imagem-01-cohros-nv-300x204.jpg 300w">
        </picture>
    </aside>
    <aside class="flex justify-center items-center bg-gray-100 w-full p-6">
        <div class="text-center max-w-md">
            <h1 class="text-2xl font-bold text-cohrosPrimary mb-7">Faça o seu Login</h1>

            <form @submit.prevent="submitForm" action="#" class="space-y-5">           
                <div>
                    <label class="input-lhpires" for="email">E-mail</label>
                    <input v-model="form.email"  class="input-lhpires" type="email" id="email" name="email">
                </div>
                <div>
                    <label class="input-lhpires" for="password">Senha</label>
                    <input v-model="form.password" class="input-lhpires" type="password" id="password" name="password" autocomplete="false">
                </div>
                <div>
                    <button class="bg-transparent text-cohrosPrimary border-2 border-cohrosPrimary hover:bg-cohrosPrimary hover:text-white font-bold text-center rounded-lg shadow-md w-full py-3 transition-colors duration-700 ease-in-out">Login</button>
                </div>                        
            </form>
        </div>
    </aside>
</section>

</template>


<script setup>
import { onMounted,reactive,ref } from 'vue';
import { useRouter } from 'vue-router'
import { useAuthStore } from '../stores/auth';
import Swal from 'sweetalert2';

const authStore = useAuthStore()


const form = reactive({
    email: '',
    password: '',
    errors: '',
});

const router = useRouter()

const submitForm = () => {
    authStore.login(form.email, form.password)
    .then((token) => {
        form.email = '';
        form.password = '';
        authStore.setUserToken(token);   

        Swal.fire({
            toast: true,
            icon: 'success',
            title: `Logado com sucesso`,
            animation: true,
            position: 'center',
            showConfirmButton: false,
            timer: 777,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        }).then(() => {
            router.push({ name: 'dashboard' })
        });


       
    })
    .catch((err) => {

        Swal.fire({
            toast: true,
            icon: 'error',
            title: `${JSON.stringify(err.message)}`,
            animation: true,
            position: 'top-right',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
    })
}

</script>
