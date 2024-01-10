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
        times: {
            type: Array
        },
    });

    let time = {};
    let showModal = ref(false);
    let alert_text = ref(null);
    let modal_title = ref(null);
    let modal_action = ref(null);
    let modal_error_text = ref(null);
    let message = ref({});
    let times = ref([]);
    let time_old = ref({});

    times = props.times;
    
    function salvaAcao(acao, jogador) {

        switch(acao) {

            case 'adicionar':
            axios.post('/times', time)
            .then(res => {

                this.showModal = false;
                this.alert_text = res.data.mensagem;
                this.time = {};
                times.unshift(res.data.time[0]);

            })
            .catch(error => {

                this.modal_error_text = error.response.data.message;
                this.message = error.response.data.errors;

            })
            break;

            case 'editar':
            axios.patch('/time/'+time.id, time)
            .then(res => {

                this.showModal = false;
                this.alert_text = res.data.mensagem;
                this.time = {};

            })
            .catch(error => {

                this.modal_error_text = error.response.data.message;
                this.message = error.response.data.errors;
                guardaValorAntigo(time, time_old, 'editar');

            })
            break;

            case 'deletar':
            axios.delete('/time/'+time.id)
            .then(res => {

                this.showModal = false;
                this.alert_text = res.data.mensagem;
                this.times.splice(times.findIndex(item => item.id === time.id), 1);

            })
            .catch(error => {

               this.modal_error_text = error.response.data.message;

           })
           break;

        }
        
    }

    function guardaValorAntigo(obj_antigo, obj_novo, acao){//no caso do usuário cancelar a edição, voltar ao que era antes na lista de itens

        if(acao == 'editar')
            Object.assign(obj_antigo, obj_novo);

    }


</script>

<template>

    <Head title="Times"/>

    <AuthenticatedLayout>

       <Modal :show="showModal" @close="showModal = false">

        <div class="flex mb-5 border-bottom-gray-200 pb-2 grid grid-rows-1 grid-cols-2 grid-flow-col">
            <h3 class="text-2xl ">{{modal_title}}</h3>
            <button class="justify-self-end self-center text-gray-400 hover:text-gray-700" @click="showModal = false; guardaValorAntigo(time, time_old, modal_action)"><i class="fas fa-xmark"></i></button>
        </div>

        <div class="m-auto bg-red-100 border-red-500 text-red-700 border px-4 py-3 rounded relative mb-6" role="alert" v-if="modal_error_text != null">
            <div class="flex grid grid-rows-1 grid-cols-1 grid-flow-col gap-4">
              <p class="font-bold">{{modal_error_text}}</p>
              <button class="justify-self-end self-center text-gray-400 hover:text-gray-700" @click="modal_error_text = null"><i class="fas fa-xmark"></i></button>         
          </div>
      </div>

      <p v-if="modal_action == 'deletar'">Tem certeza que deseja deletar o time #{{time.id}}?</p>

      <div v-if="modal_action != 'deletar'">
          <InputLabel for="nome" value="Nome" />

          <TextInput
          id="nome"
          type="text"
          class="mt-1 block w-full"
          v-model="time.nome"
          required
          autofocus
          autocomplete="nome"
          />

          <InputError class="mt-2" :message="message.nome" />
      </div>
      
    <div class="flex items-center justify-end mt-8">

        <SecondaryButton class="ms-4" @click="showModal = false; guardaValorAntigo(time, time_old, modal_action)">
            Fechar
        </SecondaryButton>

        <PrimaryButton class="ms-4" @click="salvaAcao(modal_action, time)">
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
        <h2 class="text-3xl">Times</h2>
        <button class="justify-self-end bg-emerald-700 hover:bg-emerald-900 text-gray-100 font-bold py-2 px-4 hover:text-white rounded col-start-2"  @click="showModal = true; modal_title = 'Adicionar'; modal_action = 'adicionar'; time = {}; modal_error_text = null; message = {}">
          Novo
      </button>
      <!--</div>-->
      <table class="table-auto w-full text-center row-start-2 col-span-full border border-separate rounded-md bg-gray-50 border-transparent">
          <thead class="text-gray-900">
            <tr>
              <th class=" px-4 py-2 border-bottom-gray-200">Id</th>
              <th class=" px-4 py-2 border-bottom-gray-200">Nome</th>
              <th class=" px-4 py-2 border-bottom-gray-200">A&ccedil;&otilde;es</th>
          </tr>
      </thead>
      <tbody v-for="element in times" class="/*odd:bg-gray-50*/">
          <tr>
            <td class=" px-4 py-2">{{element.id}}</td>
            <td class=" px-4 py-2">{{element.nome}}</td>
            <td class='text-center'>
              <button type="button" class="text-xl text-gray-400 hover:text-gray-700" title="Editar" style="margin-right: 0.5em;"><i class="fas fa-pen-to-square" @click="showModal = true; modal_title = 'Editar'; time = element; modal_action = 'editar'; modal_error_text = null; message = {}; guardaValorAntigo(time_old, time, modal_action)"></i></button>
              <button type="button" class="text-xl text-gray-400 hover:text-red-700" title="Deletar" style="margin-left: 0.5em;" @click="showModal = true; modal_title = 'Deletar'; modal_action = 'deletar'; time = element; modal_error_text = null; message = {}"><i class="fas fa-xmark"></i></button>
          </td>
      </tr>
  </tbody>
</table>
</div>
</div>

</AuthenticatedLayout>

</template>
