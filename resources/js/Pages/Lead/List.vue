<script setup>
import { ref, onMounted, computed } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, usePage, router } from "@inertiajs/vue3";
import TablePaginationFooter from "@/Components/TablePaginationFooter.vue";
import LeadsFilter from "./Partials/LeadsFilter.vue";
import NavLink from "@/Components/NavLink.vue";
import AddIcon from "@/Components/AddIcon.vue";
import FilterIcon from "@/Components/FilterIcon.vue";

const props = defineProps({
  leads: {
    type: Object,
  },
  tags: {
    type: Array,
  },
  alreadySelectedTags: {
    type: Array,
    default: () => [],
  },
  companies: {
    type: Array,
  },
});

const leadsHeaders = [
  {
    column: "name",
    title: "Name",
    sortable: true,
  },
  {
    column: "email",
    title: "Email",
    sortable: true,
  },
  {
    column: "phone",
    title: "Phone",
    sortable: true,
  },
  {
    column: "company",
    title: "Company",
    sortable: false,
  },
  {
    column: "converted",
    title: "Converted?",
    sortable: true,
  },
  {
    column: "is_paying",
    title: "Is paying?",
    sortable: true,
  },
  {
    column: "leadTags",
    title: "Tags",
    sortable: false,
  },
  {
    title: "Actions",
    sortable: false,
  },
];

const headersActive = leadsHeaders.filter((header) => {
  if (header.sortable === true) {
    return header;
  }
});

console.log(headersActive);

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
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl">
          <button
            class="m-5 text-center bg-gray-900 p-3 hover:bg-gray-700 duration-150 ease-in-out rounded-xl text-gray-400"
            @click="showFilterAction()"
          >
            <FilterIcon class="mt-1 ml-1 text-center text-xs"></FilterIcon>
            Filter
          </button>
          <LeadsFilter
            :show="showFilter"
            :tags="tags"
            :headers="headersActive"
            :companies="companies"
            :alreadySelectedTags="alreadySelectedTags"
            @filter="
              (params) => {
                filterMethod(params);
              }
            "
            @close="showFilter = false"
          />
          <NavLink
            class="m-3 bg-gray-900 p-3 h-full hover:bg-gray-700 duration-150 ease-in-out rounded-xl"
            :href="route('leads.create')"
          >
            <AddIcon class="mt-3 text-center text-xs" />
            <span class="mt-3">Create lead</span>
          </NavLink>
          <div class="p-3 text-gray-900 dark:text-gray-100 text-wrap overflow-x-auto">
            <table
              class="w-full border table-auto border-separate border-gray-200 dark:border-gray-700 rounded-md p-2"
            >
              <thead>
                <tr
                  class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                >
                  <th class="px-4 py-2" v-for="header in leadsHeaders">
                    {{ header.title }}
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
                  <td class="text-center p-2 rounded-sm">{{ lead.email }}</td>
                  <td class="text-center p-2 rounded-sm">{{ lead.phone }}</td>
                  <td class="text-center p-2 rounded-sm">{{ lead.company.name }}</td>

                  <td class="text-center p-2 rounded-sm">
                    {{ lead.converted ? "Yes" : "No" }}
                  </td>

                  <td class="text-center p-2 rounded-sm">
                    {{ lead.is_paying ? "Yes" : "No" }}
                  </td>

                  <td class="text-center p-2 rounded-sm">
                    <div
                      v-for="leadTag in lead.lead_tags"
                      class="inline-flex border dark:border-white-500 bg-opacity-0 items-center mt-3 ml-3 px-4 py-2 text-sm font-medium text-center text-white bg-blue-100 rounded-lg hover:bg-blue-100 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-1000 dark:hover:bg-white-500 dark:hover:text-gray-900 dark:focus:ring-blue-800"
                    >
                      {{ leadTag.tag.name }}
                    </div>
                  </td>

                  <td class="text-center p-2 rounded-sm">
                    <a
                      class="m-3 text-center text-md col-span-1 text-gray-300 bg-gray-900 p-2 hover:bg-gray-700 duration-150 ease-in-out rounded-xl"
                      :href="route('leads.show', { lead: lead })"
                    >
                      Show
                    </a>
                    <a
                      class="m-3 text-center text-md col-span-1 text-gray-300 bg-gray-900 p-2 hover:bg-gray-700 duration-150 ease-in-out rounded-xl"
                      :href="route('leads.edit', { lead: lead })"
                    >
                      Edit
                    </a>
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
