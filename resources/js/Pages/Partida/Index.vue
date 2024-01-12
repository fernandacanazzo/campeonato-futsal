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
    import axios from 'axios';
    import VueDatePicker from '@vuepic/vue-datepicker';
    import { ptBR } from 'date-fns/locale';
    import '@vuepic/vue-datepicker/dist/main.css'

    const props = defineProps({
        partidas: {
            type: Array
        },
    });

    let partida = ref({});
    let showModal = ref(false);
    let alert_text = ref(null);
    let modal_title = ref(null);
    let modal_action = ref(null);
    let modal_error_text = ref(null);
    let times = ref(null);
    let message = ref({});
    let partidas = ref([]);
    let partida_old = ref({});

    partidas = props.partidas;
    
    function salvaAcao(acao, partida) {

        switch(acao) {

            case 'adicionar':

            partida.time_id_1 = partida.time1.id;
            partida.time_id_2 = partida.time2.id;

            //corrigir horario por conta da timezone
            partida.data_inicio.setHours(partida.data_inicio.getHours() - 3);
            partida.data_termino.setHours(partida.data_termino.getHours() - 3);

            axios.post('/partidas', partida)
            .then(res => {

                this.showModal = false;
                this.alert_text = res.data.mensagem;
                this.time = {};
                partidas.unshift(res.data.partida[0]);

            })
            .catch(error => {

                this.modal_error_text = error.response.data.message;
                this.message = error.response.data.errors;

            })
            break;

            case 'editar':

            partida.time_id_1 = partida.time1.id;
            partida.time_id_2 = partida.time2.id;

            axios.patch('/partida/'+partida.id, partida)
            .then(res => {

                partida.data_inicio = new Date(partida.data_inicio).toLocaleString("pt-BR");
                partida.data_termino = new Date(partida.data_termino).toLocaleString("pt-BR");

                this.showModal = false;
                this.alert_text = res.data.mensagem;
                this.partida = {};

            })
            .catch(error => {

                this.modal_error_text = error.response.data.message;
                this.message = error.response.data.errors;
                guardaValorAntigo(partida, partida_old, 'editar');

            })

            break;

            case 'deletar':
            axios.delete('/partida/'+partida.id)
            .then(res => {

                this.showModal = false;
                this.alert_text = res.data.mensagem;
                this.partidas.splice(partidas.findIndex(item => item.id === partida.id), 1);

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

    function guardaValorAntigo(obj_antigo, obj_novo, acao){//no caso do usuário cancelar a edição, voltar ao que era antes na lista de itens

        if(acao == 'editar')
            Object.assign(obj_antigo, obj_novo);

    }

    function formataData(data_inicio, data_termino){
        
        data_inicio = data_inicio.substring(6, 10) + "-" + data_inicio.substring(3, 5) + "-" + data_inicio.substring(0, 2) + " " + data_inicio.substring(12, 17) ;
        
        this.partida.data_inicio = new Date(data_inicio);

        data_termino = data_termino.substring(6, 10) + "-" + data_termino.substring(3, 5) + "-" + data_termino.substring(0, 2) + " " + data_termino.substring(12, 17) ;
        
        this.partida.data_termino = new Date(data_termino);

    }

</script>

<template>

    <Head title="Partidas"/>

    <AuthenticatedLayout>

     <Modal :show="showModal" @close="showModal = false">

        <div class="flex mb-5 border-bottom-gray-200 pb-2 grid grid-rows-1 grid-cols-2 grid-flow-col">
            <h3 class="text-2xl ">{{modal_title}}</h3>
            <button class="justify-self-end self-center text-gray-400 hover:text-gray-700" @click="showModal = false; guardaValorAntigo(partida, partida_old, modal_action)"><i class="fas fa-xmark"></i></button>
        </div>

        <div class="m-auto bg-red-100 border-red-500 text-red-700 border px-4 py-3 rounded relative mb-6" role="alert" v-if="modal_error_text != null">
            <div class="flex grid grid-rows-1 grid-cols-1 grid-flow-col gap-4">
              <p class="font-bold">{{modal_error_text}}</p>
              <button class="justify-self-end self-center text-gray-400 hover:text-gray-700" @click="modal_error_text = null"><i class="fas fa-xmark"></i></button>         
          </div>
      </div>

      <p v-if="modal_action == 'deletar'">Tem certeza que deseja deletar a partida #{{partida.id}}?</p>

      <div v-if="modal_action != 'deletar'">

          <InputLabel for="data_inicio" value="Data In&iacute;cio" />

          <VueDatePicker v-model="partida.data_inicio" time-picker-inline :format-locale="ptBR" ></VueDatePicker>

      </div>

      <div class="mt-4" v-if="modal_action != 'deletar'">

          <InputLabel for="data_termino" value="Data T&eacute;rmino" />

          <VueDatePicker id="data_termino" v-model="partida.data_termino" time-picker-inline :min-date="new Date(partida.data_inicio)" :format-locale="ptBR"></VueDatePicker>

      </div>

      <div class="mt-4" v-if="modal_action != 'deletar'">

        <InputLabel for="time_id1" value="Time 1" />
        <select v-model="partida.time1" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="time_id1">
            <option disabled value="">Selecionar...</option>
            <option v-show="element.id != partida.time2.id" v-for="(element, index) in times"
            :value="element">
            {{element.nome}}
            </option>
        </select>

        <InputError class="mt-2" :message="message.time1" />

    </div>

    <div class="mt-4" v-if="modal_action != 'deletar'">
        <InputLabel for="placar_time_id_1" value="Placar Time 1" />

        <TextInput
        id="placar_time1"
        type="number"
        class="mt-1 block w-full"
        v-model="partida.placar_time_id_1"
        required
        autofocus
        autocomplete="placar_time_id_1"
        min="0"
        />

        <InputError class="mt-2" :message="message.placar_time_id_1" />
    </div>

    <div class="mt-4" v-if="modal_action != 'deletar'">

        <InputLabel for="time_id2" value="Time 2" />
        <select v-model="partida.time2" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="time_id2">
            <option disabled value="">Selecionar...</option>
            <option v-show="element.id != partida.time1.id" v-for="(element, index) in times" 
            :value="element">
            {{element.nome}}
            </option>
        </select>

        <InputError class="mt-2" :message="message.time1" />

    </div>

    <div class="mt-4" v-if="modal_action != 'deletar'">
        <InputLabel for="placar_time_id_2" value="Placar Time 2" />

        <TextInput
        id="placar_time2"
        type="number"
        class="mt-1 block w-full"
        v-model="partida.placar_time_id_2"
        required
        autofocus
        autocomplete="placar_time_id_2"
        min="0"
        />

        <InputError class="mt-2" :message="message.placar_time_id_2" />
    </div>
      
      <div class="flex items-center justify-end mt-8">

        <SecondaryButton class="ms-4" @click="showModal = false; guardaValorAntigo(partida, partida_old, modal_action)">
            Fechar
        </SecondaryButton>

        <PrimaryButton class="ms-4" @click="salvaAcao(modal_action, partida)">
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
        <h2 class="text-3xl">Partidas</h2>
        <button class="justify-self-end bg-emerald-700 hover:bg-emerald-900 text-gray-100 font-bold py-2 px-4 hover:text-white rounded col-start-2"  @click="showModal = true; buscaTimes(); modal_title = 'Adicionar'; modal_action = 'adicionar'; partida = {}; modal_error_text = null; message = {}; partida.time2 = ''; partida.time1 = ''">
          Novo
      </button>
      <!--</div>-->
      <table class="table-auto w-full text-center row-start-2 col-span-full border border-separate rounded-md bg-gray-50 border-transparent">
          <thead class="text-gray-900">
            <tr>
              <th class=" px-4 py-2 border-bottom-gray-200">Id</th>
              <th class=" px-4 py-2 border-bottom-gray-200">Times/Placar</th>
              <th class=" px-4 py-2 border-bottom-gray-200">Data/Hor&aacute;rio</th>
              <th class=" px-4 py-2 border-bottom-gray-200">A&ccedil;&otilde;es</th>
          </tr>
      </thead>
      <tbody v-for="element in partidas" class="/*odd:bg-gray-50*/">
          <tr>
            <td class=" px-4 py-2">{{element.id}}</td>
            <td class=" px-4 py-2">{{element.time1.nome}} <span class='text-xs'>x</span> {{element.time2.nome}}<br>
                {{element.placar_time_id_1}} <span class='text-xs'>x</span> {{element.placar_time_id_2}}</td>
                <td class=" px-4 py-2">{{element.data_inicio}} &mdash; {{element.data_termino}}</td>
                <td class='text-center'>
                  <button type="button" class="text-xl text-gray-400 hover:text-gray-700" title="Editar" style="margin-right: 0.5em;"><i class="fas fa-pen-to-square" @click="showModal = true; modal_title = 'Editar'; buscaTimes(); partida = element; modal_action = 'editar'; modal_error_text = null; message = {}; guardaValorAntigo(partida_old, partida, modal_action); formataData(partida.data_inicio, partida.data_termino)"></i></button>
                  <button type="button" class="text-xl text-gray-400 hover:text-red-700" title="Deletar" style="margin-left: 0.5em;" @click="showModal = true; modal_title = 'Deletar'; modal_action = 'deletar'; partida = element; modal_error_text = null; message = {}"><i class="fas fa-xmark"></i></button>
              </td>
          </tr>
      </tbody>
  </table>
</div>
</div>

</AuthenticatedLayout>

</template>
