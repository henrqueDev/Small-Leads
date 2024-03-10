<script setup>
import { ref, onMounted, computed } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, usePage, router } from "@inertiajs/vue3";
import TablePaginationFooter from "@/Components/TablePaginationFooter.vue";
import LeadsFilter from "./Partials/LeadsFilter.vue";
import NavLink from "@/Components/NavLink.vue";

const props = defineProps({
  leads: {
    type: Object,
  },
});

const leadsHeaders = [
  "Name",
  "Last name",
  "Email",
  "Phone",
  "Company",
  "Converted?",
  "Actions",
];

const showFilter = ref(false);

const sortBy = ref("Name");
const sortDesc = ref(false);

const showFilterAction = () => {
  showFilter.value = true;
};

const filterMethod = (filter) => {
  router.get(route("leads.list"), {
    filter: filter,
  });
};
</script>

<template>
  <AuthenticatedLayout>
    <Head title="Leads" />
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Leads
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-8xl mx-auto sm:px-6 lg:px-6">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <button class="m-5 p-2 bg-white rounded-md" @click="showFilterAction()">
            Filtro
          </button>
          <LeadsFilter
            :show="showFilter"
            @filter="
              (params) => {
                filterMethod(params);
              }
            "
            @close="showFilter = false"
          />
          <NavLink class="m-5 p-3 bg-white rounded-xl" :href="route('leads.create')"
            >+</NavLink
          >
          <div class="p-3 text-gray-900 dark:text-gray-100 text-wrap overflow-x-auto">
            <table
              class="w-full border table-auto border-separate border-gray-200 dark:border-gray-700 rounded-md p-2"
            >
              <thead>
                <tr
                  class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                >
                  <th class="px-4 py-2" v-for="header in leadsHeaders">
                    {{ header }}
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr
                  class="bg-gray-100 dark:bg-gray-700 d-flex justify-center align-items-center"
                  v-for="(lead, i) in leads.data"
                  :key="i"
                >
                  <td class="text-center p-2 rounded-sm">{{ lead.name }}</td>
                  <td class="text-center p-2 rounded-sm">{{ lead.last_name }}</td>

                  <td class="text-center p-2 rounded-sm">{{ lead.email }}</td>
                  <td class="text-center p-2 rounded-sm">{{ lead.phone }}</td>
                  <td class="text-center p-2 rounded-sm">{{ lead.company.name }}</td>

                  <td class="text-center p-2 rounded-sm">
                    {{ lead.converted ? "Yes" : "No" }}
                  </td>
                  <td class="text-center p-2 rounded-sm">
                    <NavLink :href="route('leads.show', { lead: lead })"> Show </NavLink>
                  </td>
                </tr>
              </tbody>
            </table>
            <TablePaginationFooter :links="leads.links" />
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
