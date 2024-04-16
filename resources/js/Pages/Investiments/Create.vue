<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextArea from "@/Components/TextArea.vue";
import { ref, onMounted, computed, watch, defineProps } from "vue";
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import CheckBoxDropDown from "@/Pages/Lead/Partials/CheckBoxDropDown.vue";
import AddIcon from "@/Components/AddIcon.vue";

import TextInput from "@/Components/TextInput.vue";
import DateInput from "@/Components/DateInput.vue";


const props = defineProps({
  user: {
    type: Object,
    required: true,
  },
  companies: {
    type: Array,
    required: false
  }
});


const lead = ref(props.lead);
const interaction_type_not_found = ref(false);

const form = useForm({
  description: '',
  title: '',
  amount: 0.01,
  investiment_date: '',
  company_id: null
});


const submit = () => {
  console.log(form.post(route('investiments.store')))
};

const toggleTagForm = () => {
  showTagForm.value = !showTagForm.value;

};

const loadleadSelected = (leadSelected) => {
  form.lead = Object.entries(leadSelected).map(([key, value]) => value);
};

</script>

<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Create investiment
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <form @submit.prevent="submit">
              <div class="mr-5">
                <InputLabel for="title" value="Title" />
                <TextInput
                  required
                  id="title"
                  type="text"
                  class="mt-1 block w-full"
                  v-model="form.title"
                  autofocus
                  autocomplete="title"
                />

                <InputError class="mt-2" :message="form.errors.title" />
              </div>

              <div class="mt-5 mr-5">
                <InputLabel for="description" value="Description" />
                <TextArea
                  id="description"
                  type="text"
                  class="mt-1 block w-full"
                  v-model="form.description"
                  autofocus
                  autocomplete="description"
                />

                <InputError class="mt-2" :message="form.errors.description" />
              </div>

              <div class="mt-4">
              
              </div>

              <div class="mt-4">
                <div class="inline-flex">
                  <div>
                    <InputLabel for="investiment_date" value="Event date" />
                    <DateInput required type="date" id="investiment_date" v-model="form.investiment_date" />
                    
                    <InputError class="mt-2" :message="form.errors.investiment_date" />
                  </div>

                  
                  
                  <div class="ml-5">
                    <InputLabel for="company" value="Company" />
                    <select
                    :disabled="company_not_found"
                    required
                    class="w-75 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    v-model="form.company_id"
                  >
                    <option
                      v-for="company in companies"
                      :value="company.id"
                      :key="company.id"
                    >
                      {{ company.name }}
                    </option>
                  </select>
                    
                    <InputError class="mt-2" :message="form.errors.company_id" />
                  </div>
                 
                </div>
                
              </div>
              

              <div class="mt-4">
                <div>
                    <InputLabel for="amount" value="Amount($)" />
                    <TextInput required type="number" id="amount" v-model="form.amount" />
                    
                    <InputError class="mt-2" :message="form.errors.amount" />
                </div>
              </div>

              <div class="flex items-center justify-center mt-4">
                <PrimaryButton
                  class="ms-1"
                  :class="{ 'opacity-25': form.processing }"
                  :disabled="form.processing"
                  @click="submit()"
                >
                  Register
                </PrimaryButton>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
