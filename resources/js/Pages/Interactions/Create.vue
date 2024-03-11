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
  leads: {
    type: Object,
    required: false,
  },
});

console.log(props.leads)

const leads = ref(props.leads);
const lead_not_found = ref(false);

const form = useForm({
  description: "",
  event_date: "",
  interaction_type_id: null,
  lead_id: null,
});


const submit = () => {
  form.post(route("leads.store"));
};

const toggleTagForm = () => {
  showTagForm.value = !showTagForm.value;
};

const loadleadsSelected = (leadsSelected) => {
  console.log(leadsSelected);
  form.leads = Object.entries(leadsSelected).map(([key, value]) => value);

  console.log(form.leads);
};
</script>

<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Create lead
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <form @submit.prevent="submit">
              <div class="mr-5">
                <InputLabel for="description" value="Description" />
                <TextArea class="mt-1 inline-flex w-full h-auto" id="description">
                </TextArea>
                <!--
                <TextInput
                  id="description"
                  type="text"
                  class="mt-1 block w-full"
                  v-model="form.description"
                  required
                  autofocus
                  autocomplete="description"
                />

                <InputError class="mt-2" :message="form.errors.description" />
                -->
              </div>

              <div class="mt-4"></div>

              <div class="mt-4">
                <div>
                  <InputLabel for="lead" value="Lead" />
                  <select
                    required
                    class="w-75 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    v-model="form.lead_id"
                  >
                    <option v-for="lead in leads" :value="lead.id" :key="lead.id">
                      {{ lead.name }}
                    </option>
                  </select>
                </div>
              </div>

              <div class="mt-4">
                <InputLabel for="event_date" value="Lead" />
                <DateInput type="date" id="event_date" v-model="form.event_date" required />
                <br />
              </div>

              <div class="flex items-center justify-center mt-4">
                <PrimaryButton
                  class="ms-1"
                  :class="{ 'opacity-25': form.processing }"
                  :disabled="form.processing"
                >
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
