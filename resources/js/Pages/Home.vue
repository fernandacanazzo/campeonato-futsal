<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';
    import { ref } from 'vue';
    import axios from 'axios';

    const props = defineProps({
        classificacao: {
            type: Array
        },
    });

    let classificacao = ref([]);

    classificacao = props.classificacao;

    function redireciona(url){

        window.location='/'+url;
    }

</script>

<template>
    <Head title="Home" />

    <AuthenticatedLayout>

     <div class="container mx-auto mt-16">

        <h2 class="text-2xl mb-4">Classifica&ccedil;&atilde;o</h2>

        <div class="grid grid-rows-3 grid-cols-3 grid-flow-col gap-4 justify-items-center">
            <div class="row-span-3 row-end-3 col-span-2 w-full">             

                <table class="table-auto w-full text-center row-start-2 col-span-full border border-separate rounded-md bg-gray-50 border-transparent">
                  <thead class="text-gray-900">
                    <tr>
                      <th class=" px-4 py-2 border-bottom-gray-200">Posi&ccedil;&atilde;o</th>
                      <th class=" px-4 py-2 border-bottom-gray-200">Times</th>
                      <th class=" px-4 py-2 border-bottom-gray-200">Pontos</th>
                      <th class=" px-4 py-2 border-bottom-gray-200">Quantidade de Gols</th>
                  </tr>
              </thead>
              <tbody v-for="(element, index) in classificacao">
                  <tr>
                    <td class=" px-4 py-2">{{index+1}}</td>
                    <td class=" px-4 py-2">{{element.time.nome}}</td>
                    <td class=" px-4 py-2">{{element.pontos}}</td>
                    <td class=" px-4 py-2">{{element.qtd_gols}}</td>
                </tr>
            </tbody>
        </table>

    </div>
    <div class="col-span-3 col-start-3 justify-items-center">
        <div>
            <button class="w-60 bg-gray-300 hover:bg-gray-700 text-gray-800 font-bold py-2 px-4 hover:text-white rounded mb-5 mx-auto" @click="redireciona('jogadores')">
            Jogadores
            </button>
        </div>
        <div>
            <button class="w-60 bg-gray-300 hover:bg-gray-700 text-gray-800 font-bold py-2 px-4 hover:text-white rounded mb-5 mx-auto" @click="redireciona('partidas')">
            Partidas
            </button>
        </div>
        <div>
            <button class="w-60 bg-gray-300 hover:bg-gray-700 text-gray-800 font-bold py-2 px-4 hover:text-white rounded mx-auto" @click="redireciona('times')">
            Times
            </button>
        </div>
    </div>       
    </div>
</div>

</AuthenticatedLayout>
</template>
