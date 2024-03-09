<script setup>
import { ref, onMounted, computed } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, usePage, router } from "@inertiajs/vue3";
import NavLink from "@/Components/NavLink.vue";

const props = defineProps({
  tags: {
    type: Object,
  },
});

const tagsHeaders = [
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
  router.get(route("tags.list"), {
    filter: filter,
  });
};
</script>

<template>
  <AuthenticatedLayout>
    <Head title="tags" />
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 taging-tight">
        tags
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <button class="m-5 p-2 bg-white rounded-md" @click="showFilterAction()">
            Filtro
          </button>
          <tagsFilter
            :show="showFilter"
            @filter="
              (params) => {
                filterMethod(params);
              }
            "
            @close="showFilter = false"
          />
          <div class="p-3 text-gray-900 dark:text-gray-100">
            <table
              class="w-full border border-separate border-gray-200 dark:border-gray-700 rounded-md p-2"
            >
              <thead>
                <tr
                  class="font-semibold text-xl text-gray-800 dark:text-gray-200 taging-tight"
                >
                  <th class="px-4 py-2" v-for="header in tagsHeaders">
                    {{ header }}
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr
                  class="bg-gray-100 dark:bg-gray-700 d-flex justify-center align-items-center"
                  v-for="(tag, i) in tags.data"
                  :key="i"
                >
                  <td class="text-center p-2 rounded-sm">{{ tag.name }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
