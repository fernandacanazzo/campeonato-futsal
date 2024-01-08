<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/vue3';
    import Modal from '@/Components/Modal.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import { ref } from 'vue';
    import axios from 'axios'

    const props = defineProps({
        jogadores: {
            type: Array
        },
    });

    const showModal = ref(false);

    const nome = '';
    const time = '';

    const test = [];

    const getJogadores = (nome, time) => {
        axios.get('/teste')
        .then(res => {

            console.log(res.data, nome, time)

        })
        .catch(error => console.log(error))

    }

</script>

<template>

    <Head title="Jogadores"/>

    <AuthenticatedLayout>

     <Modal :show="showModal" @close="showModal = false">

        <div class="flex mb-5 border-bottom-gray-200 pb-2 grid grid-rows-1 grid-cols-2 grid-flow-col">
            <h3 class="text-2xl ">Adicionar</h3>
            <button class="justify-self-end self-center text-gray-500" @click="showModal = false"><i class="fas fa-xmark"></i></button>
        </div>
            
            <div>
                <InputLabel for="nome" value="Nome" />

                <TextInput
                id="nome"
                type="text"
                class="mt-1 block w-full"
                v-model="nome"
                required
                autofocus
                autocomplete="nome"
                />

               <!-- <InputError class="mt-2" :message="form.errors.nome" />-->
            </div>

            <div class="mt-4">

                <InputLabel for="time" value="Time" />
                <select v-model="time" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                  <option disabled value="">Selecionar...</option>
                  <option value="1">Palmeiras</option>
              </select>

          </div>
          <div class="flex items-center justify-end mt-8">

            <PrimaryButton class="ms-4" @click="getJogadores(nome, time)">
                Salvar
            </PrimaryButton>

        </div>

</Modal>

<div class="container mx-auto mt-20 justify-items-center">

 <div class="grid grid-rows-1 grid-cols-2 grid-flow-col gap-4 w-9/12 m-auto">
    <!--<div>-->
        <h2 class="text-3xl">Jogadores</h2>
        <button class="justify-self-end bg-emerald-700 hover:bg-emerald-900 text-gray-100 font-bold py-2 px-4 hover:text-white rounded col-start-2"  @click="showModal = true">
          Novo
      </button>
      <!--</div>-->
      <table class="table-auto w-full text-center row-start-2 col-span-full border border-separate rounded-md bg-gray-50 border-transparent">
          <thead class="text-gray-900">
            <tr>
              <th class=" px-4 py-2 border-bottom-gray-200">Id</th>
              <th class=" px-4 py-2 border-bottom-gray-200">Nome</th>
              <th class=" px-4 py-2 border-bottom-gray-200">Time</th>
          </tr>
      </thead>
      <tbody v-for="element in $page.props.jogadores" class="/*odd:bg-gray-50*/">
          <tr>
            <td class=" px-4 py-2">{{element.id}}</td>
            <td class=" px-4 py-2">{{element.nome}}</td>
            <td class=" px-4 py-2">{{element.time_id}}</td>
        </tr>
    </tbody>
</table>
</div>
</div>

</AuthenticatedLayout>

</template>
