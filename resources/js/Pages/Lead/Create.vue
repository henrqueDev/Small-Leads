<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref, onMounted, computed } from "vue";
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';

const companies = ref([]);

async function fetchData() {
  try {
    const response = await axios.get('/api/companies');
    companies.value = response.data;
  } catch (error) {
    console.error("Error fetching mineral log data:", error);
  }
}

onMounted(fetchData);


  
const form = useForm({
    name: '',
    last_name: '',
    email: '',
    phone: '',
    company_id: null
});

const submit = () => {
    form.post(route('leads.store'));
};
</script>

<template>
    <AuthenticatedLayout>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Cadastrar lead</h2>
        </template>

        <div class="py-12">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form @submit.prevent="submit">
                            <div class="grid grid-cols-2">
                                <div class="mr-5">
                                    <InputLabel for="name" value="Name" />

                                    <TextInput
                                        id="name"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.name"
                                        required
                                        autofocus
                                        autocomplete="name"
                                    />

                                    <InputError class="mt-2" :message="form.errors.name" />
                                </div>

                                <div>
                
                                    <InputLabel for="last_name" value="Sobrenome" />

                                    <TextInput
                                        id="last_name"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.last_name"
                                        required
                                        autofocus
                                        autocomplete="companiename"
                                    />

                                    <InputError class="mt-2" :message="form.errors.last_name" />
                                </div>
                            </div>

                            <div class="mt-4">
                                
                            </div>

                            <div class="mt-4">
                                <InputLabel for="email" value="Email" />

                                <TextInput
                                    id="email"
                                    type="email"
                                    class="mt-1 block w-full"
                                    v-model="form.email"
                                    required
                                    autocomplete="new-email"
                                />

                                <InputError class="mt-2" :message="form.errors.email" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="phone" value="Telefone" />

                                <TextInput
                                    id="phone"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.phone"
                                    required
                                    autofocus
                                    autocomplete="new-phone"
                                />

                                <InputError class="mt-2" :message="form.errors.phone" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="company" value="Company" />
                                <select
                                    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                    v-model="form.company_id"
                                >  
                                    <option v-for="company in companies" :value="company.id" :key="company.id">
                                        {{ company.name }} 
                                    </option>
                                </select>
                            
                            </div>

                            <div class="flex items-center justify-center mt-4">

                                <PrimaryButton class="ms-1" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Create
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
