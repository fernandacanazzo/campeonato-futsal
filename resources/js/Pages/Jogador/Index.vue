<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/vue3';
    import Modal from '@/Components/Modal.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import SecondaryButton from '@/Components/SecondaryButton.vue';
    import { ref } from 'vue';
    import axios from 'axios'

    const props = defineProps({
        jogadores: {
            type: Array
        },
    });

    let jogador = {};
    let showModal = ref(false);
    let alert_text = ref(null);
    let modal_title = ref(null);
    let modal_action = ref(null);
    let modal_error_text = ref(null);
    let times = ref(null);
    let message = ref({});
    let jogadores = ref([]);
    let jogador_old = ref({});

    jogadores = props.jogadores;
    
    function salvaAcao(acao, jogador) {

        switch(acao) {

            case 'adicionar':

            jogador.time_id = jogador.time.id;
            axios.post('/jogadores', jogador)
            .then(res => {

                this.showModal = false;
                this.alert_text = res.data.mensagem;
                this.jogador = {};
                jogadores.unshift(res.data.jogador[0]);

            })
            .catch(error => {

                this.modal_error_text = error.response.data.message;
                this.message = error.response.data.errors;

            })
            break;

            case 'editar':

            jogador.time_id = jogador.time.id;
            axios.patch('/jogador/'+jogador.id, jogador)
            .then(res => {

                this.showModal = false;
                this.alert_text = res.data.mensagem;
                this.jogador = {};

            })
            .catch(error => {

                this.modal_error_text = error.response.data.message;
                this.message = error.response.data.errors;
                guardaValorAntigo(jogador, jogador_old, 'editar');

            })
            break;

            case 'deletar':
            axios.delete('/jogador/'+jogador.id)
            .then(res => {

                this.showModal = false;
                this.alert_text = res.data.mensagem;
                this.jogadores.splice(jogadores.findIndex(item => item.id === jogador.id), 1);

            })
            .catch(error => {

               this.modal_error_text = error.response.data.message;

           })
           break;

        }
        
    } 

    function buscaTimes() {

        axios.get('/times/busca')
        .then(res => {

            this.times = res.data.times;

        })
        .catch(error => {

        })

    }

    function guardaValorAntigo(obj_antigo, obj_novo, acao){//no caso do usu�rio cancelar a edi��o, voltar ao que era antes na lista de itens

        if(acao == 'editar')
            Object.assign(obj_antigo, obj_novo);

    }


</script>

<template>

    <Head title="Jogadores"/>

    <AuthenticatedLayout>

       <Modal :show="showModal" @close="showModal = false">

        <div class="flex mb-5 border-bottom-gray-200 pb-2 grid grid-rows-1 grid-cols-2 grid-flow-col">
            <h3 class="text-2xl ">{{modal_title}}</h3>
            <button class="justify-self-end self-center text-gray-400 hover:text-gray-700" @click="showModal = false; guardaValorAntigo(jogador, jogador_old, modal_action)"><i class="fas fa-xmark"></i></button>
        </div>

        <div class="m-auto bg-red-100 border-red-500 text-red-700 border px-4 py-3 rounded relative mb-6" role="alert" v-if="modal_error_text != null">
            <div class="flex grid grid-rows-1 grid-cols-1 grid-flow-col gap-4">
              <p class="font-bold">{{modal_error_text}}</p>
              <button class="justify-self-end self-center text-gray-400 hover:text-gray-700" @click="modal_error_text = null"><i class="fas fa-xmark"></i></button>         
          </div>
      </div>

      <p v-if="modal_action == 'deletar'">Tem certeza que deseja deletar o Jogador #{{jogador.id}}?</p>

      <div v-if="modal_action != 'deletar'">
          <InputLabel for="nome" value="Nome" />

          <TextInput
          id="nome"
          type="text"
          class="mt-1 block w-full"
          v-model="jogador.nome"
          required
          autofocus
          autocomplete="nome"
          />

          <InputError class="mt-2" :message="message.nome" />
      </div>

      <div class="mt-4" v-if="modal_action != 'deletar'">
        <InputLabel for="numero_camiseta" value="N&uacute;mero Camiseta" />

        <TextInput
        id="numero_camiseta"
        type="number"
        class="mt-1 block w-full"
        v-model="jogador.numero_camiseta"
        required
        autofocus
        autocomplete="numero_camiseta"
        />

        <InputError class="mt-2" :message="message.numero_camiseta" />
    </div>

    <div class="mt-4" v-if="modal_action != 'deletar'">

        <InputLabel for="time_id" value="Time" />
        <select v-model="jogador.time" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
            <option disabled value="">Selecionar...</option>
            <option v-for="(element, index) in times" 
            :value="element" 
            :key="element.id">
            {{element.nome}}
            </option>
        </select>

        <InputError class="mt-2" :message="message.time" />

    </div>
    <div class="flex items-center justify-end mt-8">

        <SecondaryButton class="ms-4" @click="showModal = false; guardaValorAntigo(jogador, jogador_old, modal_action)">
            Fechar
        </SecondaryButton>

        <PrimaryButton class="ms-4" @click="salvaAcao(modal_action, jogador)">
            Salvar
        </PrimaryButton>

    </div>

</Modal>

<div class="container mx-auto mt-20 justify-items-center">
    <div class="m-auto bg-sky-100 border-sky-500 text-sky-700 border px-4 py-3 rounded relative mb-6 w-9/12" role="alert" v-if="alert_text != null">
        <div class="flex grid grid-rows-1 grid-cols-1 grid-flow-col gap-4">
          <p class="font-bold">{{alert_text}}</p>
          <button class="justify-self-end self-center text-gray-400 hover:text-gray-700" @click="alert_text = null"><i class="fas fa-xmark"></i></button>         
      </div>
  </div>

  <div class="grid grid-rows-1 grid-cols-2 grid-flow-col gap-4 w-9/12 m-auto">
    <!--<div>-->
        <h2 class="text-3xl">Jogadores</h2>
        <button class="justify-self-end bg-emerald-700 hover:bg-emerald-900 text-gray-100 font-bold py-2 px-4 hover:text-white rounded col-start-2"  @click="showModal = true; buscaTimes(); modal_title = 'Adicionar'; modal_action = 'adicionar'; jogador = {}; modal_error_text = null">
          Novo
      </button>
      <!--</div>-->
      <table class="table-auto w-full text-center row-start-2 col-span-full border border-separate rounded-md bg-gray-50 border-transparent">
          <thead class="text-gray-900">
            <tr>
              <th class=" px-4 py-2 border-bottom-gray-200">Id</th>
              <th class=" px-4 py-2 border-bottom-gray-200">Nome</th>
              <th class=" px-4 py-2 border-bottom-gray-200">N&uacute;mero Camiseta</th>
              <th class=" px-4 py-2 border-bottom-gray-200">Time</th>
              <th class=" px-4 py-2 border-bottom-gray-200">A&ccedil;&otilde;es</th>
          </tr>
      </thead>
      <tbody v-for="element in jogadores" class="/*odd:bg-gray-50*/">
          <tr>
            <td class=" px-4 py-2">{{element.id}}</td>
            <td class=" px-4 py-2">{{element.nome}}</td>
            <td class=" px-4 py-2">{{element.numero_camiseta}}</td>
            <td class=" px-4 py-2">{{element.time.nome}}</td>
            <td class='text-center'>
              <button type="button" class="text-xl text-gray-400 hover:text-gray-700" title="Editar" style="margin-right: 0.5em;"><i class="fas fa-pen-to-square" @click="showModal = true; modal_title = 'Editar'; jogador = element; modal_action = 'editar'; buscaTimes(); modal_error_text = null; message = {}; guardaValorAntigo(jogador_old, jogador, modal_action)"></i></button>
              <button type="button" class="text-xl text-gray-400 hover:text-red-700" title="Deletar" style="margin-left: 0.5em;" @click="showModal = true; modal_title = 'Deletar'; modal_action = 'deletar'; jogador = element; modal_error_text = null; message = {}"><i class="fas fa-xmark"></i></button>
          </td>
      </tr>
  </tbody>
</table>
</div>
</div>

</AuthenticatedLayout>

</template>
