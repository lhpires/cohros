<template>
<div>
   <div @click="$emit('close-modal')" class="bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-40 block cursor-pointer"></div>
   <div class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal h-full justify-center items-center flex" tabindex="0">
      <div class="max-w-2xl relative p-4 w-full h-full">
         <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="border-b border-gray-200 dark:border-gray-600 p-4 rounded-t flex justify-between items-center">
               <div class="flex items-center text-lg"> <slot name="title">Título Modal</slot> </div>
               <button @click="$emit('close-modal')" aria-label="close" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" type="button">
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                     <path clip-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" fill-rule="evenodd"></path>
                  </svg>
               </button>
            </div>
            <div class="p-6">
               <slot></slot>
            </div>
            <div class="p-6 rounded-b border-gray-200 border-t dark:border-gray-600">
               <div class="flex justify-between">
                    <slot name="actions"></slot>
                  <!-- <button class="font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 hover:bg-gray-100 hover:text-cohrosPrimary dark:hover:text-white dark:hover:bg-gray-700 text-sm px-4 py-2" href="">
                     <span class="">
                        Decline
                     </span>
                  </button>
                  <button class="focus:outline-none text-white bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg dark:bg-green-600 dark:focus:ring-green-800 hover:bg-green-800 dark:hover:bg-green-700 text-sm px-4 py-2" href="">
                     <span class="">
                         I accept 
                     </span>
                  </button> -->
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</template>

<script setup>
import { defineEmits } from 'vue';

defineEmits(['close-modal']);

</script>