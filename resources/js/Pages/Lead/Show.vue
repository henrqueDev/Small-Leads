<script setup>
import { ref, onMounted, computed } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, usePage, router } from "@inertiajs/vue3";
import TablePaginationFooter from "@/Components/TablePaginationFooter.vue";
import LeadsFilter from "./Partials/LeadsFilter.vue";

const props = defineProps({
  lead: {
    type: Object,
    required: true,
  },
});

const leadsHeaders = [
  "Name",
  "Last name",
  "Email",
  "Phone",
  "Company",
  "Tags",
  "Converted?",
];

console.log(props.lead);
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
      <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-3 text-gray-900 dark:text-gray-100">
            <table
              class="w-full border border-separate border-gray-200 dark:border-gray-700 rounded-md p-2"
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
                >
                  <td class="text-center p-2 rounded-sm">{{ props.lead.name }}</td>
                  <td class="text-center p-2 rounded-sm">{{ props.lead.last_name }}</td>

                  <td class="text-center p-2 rounded-sm">{{ props.lead.email }}</td>
                  <td class="text-center p-2 rounded-sm">{{ props.lead.phone }}</td>
                  <td class="text-center p-2 rounded-sm">
                    {{ props.lead.company.name }}
                  </td>

                  <td class="text-center p-2 rounded-sm">
                    <div
                      class="mt-2 border dark:border-white-500 bg-opacity-0 items-center ml-3 px-4 py-2 text-xs font-medium text-center text-white bg-blue-100 rounded-lg hover:bg-blue-100 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-1000 dark:hover:bg-white-500 dark:hover:text-gray-900 dark:focus:ring-blue-800"
                      v-for="lead_tag in props.lead.lead_tags"
                    >
                      {{ lead_tag.tag.name }}
                    </div>
                  </td>

                  <td class="text-center p-2 rounded-sm">
                    {{ props.lead.converted ? "Yes" : "No" }}
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
