<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';

function redireciona(url){

    window.location='/'+url;
}

</script>

<template>
    <Head title="Home" />

    <AuthenticatedLayout>
       <!-- <template #header>
        
       </template>-->

       <div class="container mx-auto mt-20">
        <div class="grid grid-rows-3 grid-cols-3 grid-flow-col gap-4 justify-items-center">
            <div class="row-span-3 row-end-3 col-span-2 w-full">
                <div style="background: white; height: 100%;">Classificacao</div></div>
              <div class="col-span-1 col-start-3">
                <button class="w-60 bg-gray-300 hover:bg-gray-700 text-gray-800 font-bold py-2 px-4 hover:text-white rounded" @click="redireciona('jogador')">
                  Jogadores
              </button></div>
              <div class="col-span-1 col-start-3">
                <button class="w-60 bg-gray-300 hover:bg-gray-700 text-gray-800 font-bold py-2 px-4 hover:text-white rounded" @click="redireciona('partid')">
                  Partidas
              </button></div>
              <div class="col-span-1 col-start-3">
                <button class="w-60 bg-gray-300 hover:bg-gray-700 text-gray-800 font-bold py-2 px-4 hover:text-white rounded" @click="redireciona('time')">
                  Times
              </button></div>         
          </div>
      </div>

      <div>




      </div>

        <!--<div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in!</div>
                </div>
            </div>
        </div>-->
    </AuthenticatedLayout>
</template>
