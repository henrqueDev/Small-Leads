<script setup>
import { ref, onMounted, computed } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, usePage, router } from "@inertiajs/vue3";
import TablePaginationFooter from "@/Components/TablePaginationFooter.vue";
import NavLink from "@/Components/NavLink.vue";
import AddIcon from "@/Components/AddIcon.vue";
import ExportDocumentIcon from "@/Components/ExportDocumentIcon.vue";
import FilterIcon from "@/Components/FilterIcon.vue";
import SearchIcon from '@/Components/SearchIcon.vue';
import ModalDescription from '@/Pages/Interactions/Partials/ModalDescription.vue';

const props = defineProps({
  investiments: {
    type: Object,
  }
});

const investimentsHeaders = [
  {
    column: "title",
    title: "Title",
    sortable: true,
  },
  {
    column: "lead",
    title: "Lead",
    sortable: true,
  },
  
  {
    column: "company",
    title: "Company",
    sortable: true,
  },
  {
    column: "amount",
    title: "Amount ($)",
    sortable: true,
  },
  {
    column: "description",
    title: "Description",
    sortable: true,
  },
  {
    column: "investiment_date",
    title: "Date",
    sortable: true,
  },
  {
    title: "Actions",
    sortable: false,
  },
];

const headersActive = investimentsHeaders.filter((header) => {
  if (header.sortable === true) {
    return header;
  }
});

console.log(headersActive);

const showFilter = ref(false);

const sortBy = ref("title");
const sortDesc = ref(false);

const showModal = ref(false);
const showModalDescription = ref(false);

const showModalAction = (description) => {
  showModal.value = true;
  showModalDescription.value = description
};

</script>

<template>
  <AuthenticatedLayout>
    <Head title="Investiments" />
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Investiments
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-8xl mx-auto sm:px-6 lg:px-6">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl">
        
          <ModalDescription :show="showModal" :description="showModalDescription" @close="showModal=false" />
          <NavLink
            class="m-3 bg-gray-900 p-3 h-full hover:bg-gray-700 duration-150 ease-in-out rounded-xl"
            :href="route('investiments.create')"
          >
            <AddIcon class="mt-3 text-center text-xs" />
            <span class="mt-3">Create investiment</span>
          </NavLink>
          <a
                      class="m-3 text-center text-md col-span-1 text-gray-300 bg-gray-900 p-2 hover:bg-gray-700 duration-150 ease-in-out rounded-xl cursor"
                      :href="route('investiments.export.csv')"
          >
            <span class="mt-3">Export</span>
          </a>
          <div class="p-3 text-gray-900 dark:text-gray-100 text-wrap overflow-x-auto">
            <table
              class="w-full border table-auto border-separate border-gray-200 dark:border-gray-700 rounded-md p-2"
            >
              <thead>
                <tr
                  class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                >
                  <th class="px-4 py-2" v-for="header in investimentsHeaders">
                    {{ header.title }}
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr
                  class="bg-gray-100 dark:bg-gray-700 d-flex justify-center align-items-center"
                  v-for="(investiment, i) in investiments.data"
                  :key="i"
                >
                  <td class="text-center p-2 rounded-sm">{{ investiment.title }}</td>
                  
                  <td class="text-center p-2 rounded-sm">{{ investiment.lead.name }}</td>
                  
                  
                  <td class="text-center p-2 rounded-sm">{{ investiment.lead.company.name }}</td>
                  <td class="text-center p-2 rounded-sm">{{ investiment.amount }}</td>
                  <td class="text-center p-2 rounded-sm">
                    <button
                      class="m-3 text-md col-span-1 p-3 text-white bg-gray-900 p-3 hover:bg-gray-700 duration-150 ease-in-out rounded-xl"
                      @click="showModalAction(investiment.description)"
                    ><SearchIcon /></button>
                  </td>
                  <td class="text-center p-2 rounded-sm">{{ investiment.investiment_date }}</td>

                  <td class="text-center p-2 rounded-sm">
                    <a
                      class="m-3 text-center text-md col-span-1 text-gray-300 bg-gray-900 p-2 hover:bg-gray-700 duration-150 ease-in-out rounded-xl cursor"
                      :href="route('investiments.edit', {investiment: investiment.id })"
                    >
                      Edit
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
            <TablePaginationFooter :links="investiments.links" />
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
