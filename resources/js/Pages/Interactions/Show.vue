<script setup>
import { ref, onMounted, computed } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, usePage, router } from "@inertiajs/vue3";
import TablePaginationFooter from "@/Components/TablePaginationFooter.vue";
import moment from "moment";
import NavLink from "@/Components/NavLink.vue";
import TextArea from "@/Components/TextArea.vue";
import SearchIcon from '@/Components/SearchIcon.vue';
import ModalDescription from './Partials/ModalDescription.vue';

const props = defineProps({
  interaction: {
    type: Object,
    required: true,
  },
  lead: {
    type: Object,
    required: false,
  },
});

const showModal = ref(false);
const showModalDescription = ref('');
const showModalAction = (description) => {
  showModal.value = true;
  showModalDescription.value = description
};
const interactionHeaders = ["Type", "Date", "Description", "Actions"];
</script>

<template>
  <AuthenticatedLayout>
    <Head title="Interaction" />
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Interaction
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        
          
          <ModalDescription :show="showModal" :description="showModalDescription" @close="showModal=false" />
          <div class="p-3 text-gray-900 dark:text-gray-100">
            <table
              class="w-full border border-separate border-gray-200 dark:border-gray-700 rounded-md p-2"
            >
              <thead>
                <tr
                  class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                >
                  <th class="px-4 py-2" v-for="header in interactionHeaders">
                    {{ header }}
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr
                  class="bg-gray-100 dark:bg-gray-700 d-flex justify-center align-items-center"
                >
                  <td class="text-center p-2 rounded-sm">
                    {{ interaction.interaction_type.name }}
                  </td>

                  <td class="text-center p-2 rounded-sm">
                    {{ moment(interaction.event_date).format("MM/DD/YYYY") }}
                  </td>

                  <td class="text-center p-2 rounded-sm">
                    <button
                      class="m-3 text-md col-span-1 p-3 text-white bg-gray-900 p-3 hover:bg-gray-700 duration-150 ease-in-out rounded-xl"
                      @click="showModalAction(interaction.description)"
                    ><SearchIcon /></button>
                  </td>

                  <td class="text-center p-2 rounded-sm">
                    <NavLink
                      :href="route('interactions.edit', { interaction: interaction.id })"
                    >
                      Edit
                    </NavLink>

                    <NavLink
                      :href="
                        route('interactions.destroy', { interaction: interaction.id })
                      "
                    >
                      Delete
                    </NavLink>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
