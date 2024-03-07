<script setup>

import { ref, onMounted, computed } from "vue";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    leads: {
        type: Array
    }
});


const leadsHeaders = [
    "Nome",
    "Sobrenome",
    "Empresa",
    "Telefone",
    "Convertido?"
]


const sortBy = ref("Nome");  
const sortDesc = ref(false);

const sortLeads = (header, list) => {
  const headerValue = header.toLowerCase();
  const isCurrentSort = headerValue === sortBy.value;

  sortDesc.value = isCurrentSort ? !sortDesc.value : false;
  sortBy.value = headerValue;

  list.sort((a, b) => {
    const firstValue = a[sortBy.value];
    const secondValue = b[sortBy.value];

    if (sortDesc.value) {
      return secondValue.localeCompare(firstValue);
    } else {
      return firstValue.localeCompare(secondValue);
    }
  });
};


</script>

<template>
    <Head title="Leads" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Leads</h2>
        </template>

    <div class="py-12">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">

                        <table class="w-full border border-separate border-gray-200 dark:border-gray-700 rounded-md p-2">
                            <thead>
                                <tr class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                                    <th 
                                        class="px-4 py-2"
                                        v-for="header in leadsHeaders"
                                    >  
                                            {{ header }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr  class="bg-gray-100 dark:bg-gray-700 d-flex justify-center align-items-center" v-for="(lead,i) in leads" :key="i">
                                    <td class="text-center">{{ lead.name  }}</td>
                                    <td class="text-center">{{ lead.last_name }}</td>
                                    <td class="text-center">{{ lead.company.name }}</td> 
                                    <td class="text-center">{{ lead.phone }}</td>
                                    <td class="text-center">{{ lead.converted ? 'Sim' : 'Não' }}</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
