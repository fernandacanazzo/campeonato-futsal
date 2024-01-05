<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';

    const props = defineProps({
        jogadores: {
            type: Array
        },
    });
</script>

<template>

    <Head title="Jogadores"/>

    <AuthenticatedLayout>

        <div class="container mx-auto mt-20 justify-items-center">
         <div class="grid grid-rows-1 grid-cols-1 grid-flow-col gap-4 w-9/12 m-auto">
             <table class="table-auto w-full striped text-center">
              <thead class="bg-gray-50">
                <tr class="">
                  <th class="border px-4 py-2">Id</th>
                  <th class="border px-4 py-2">Nome</th>
                  <th class="border px-4 py-2">Time</th>
              </tr>
          </thead>
          <tbody v-for="element in $page.props.jogadores" class="odd:bg-gray-50">
              <tr>
                <td class="border px-4 py-2">{{element.id}}</td>
                  <td class="border px-4 py-2">{{element.nome}}</td>
                  <td class="border px-4 py-2">{{element.time_id}}</td>
              </tr>
          </tbody>
      </table>
  </div>
</div>

</AuthenticatedLayout>

</template>
