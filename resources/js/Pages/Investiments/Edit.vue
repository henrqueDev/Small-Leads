<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import TextArea from "@/Components/TextArea.vue";
import { ref, onMounted, computed, watch, defineProps } from "vue";
import { Head, Link, useForm, usePage, router } from "@inertiajs/vue3";
import CheckBoxDropDown from "@/Pages/Lead/Partials/CheckBoxDropDown.vue";
import AddIcon from "@/Components/AddIcon.vue";
import DangerButton from "@/Components/DangerButton.vue";
import Swal from "sweetalert2";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
  tags: {
    type: Object,
    required: false,
  },
  investiment: {
    type: Object,
    required: true,
  },
  companies: {
    type: Array,
    required: false,
  },
});

const form = useForm({
  id: props.investiment.id,
  title: props.investiment.title,
  description: props.investiment.description,
  investiment_date: props.investiment.investiment_date,
  amount: props.investiment.amount,
  company_id: props.investiment.company_id
});

watch(form, () => {
  if(form.converted == false) {
    form.is_paying = false;
  }
})

const updateInvestiment = () => {
  form.patch(route("investiments.update", { investiment: form.id }));
};

const toggleTagForm = () => {
  showTagForm.value = !showTagForm.value;
};

const loadTagsSelected = (tagsSelected) => {
  form.tags = Object.entries(tagsSelected).map(([key, value]) => value);
};

const deleteInvestiment = () => {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it!",
    cancelButtonText: "No, cancel!",
    reverseButtons: true,
  }).then((result) => {
    if (result.isConfirmed) {
      router.delete(route("investiment.destroy", { investiment: props.investiment.id }));
    }
  });
};
</script>

<template>
  <AuthenticatedLayout>
  
    <Head title="Edit Lead" />
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Edit investiment
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <form @submit.prevent="updateLead()">
              <div>
                <div class="mb-5">
                  <InputLabel for="title" value="Title" />

                  <TextInput
                    id="title"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.title"
                    required
                    autofocus
                    autocomplete="title"
                  />

                  <InputError class="mt-2" :message="form.errors.title" />
                </div>

              </div>

              <div class="mt-4"></div>

              <div class="mt-4">
                <InputLabel for="description" value="Description" />

                <TextArea
                  id="description"
                  type="description"
                  class="mt-1 block w-full"
                  v-model="form.description"
                  required
                  autocomplete="new-description"
                />

                <InputError class="mt-2" :message="form.errors.description" />
              </div>

              <div class="mt-4 grid grid-cols-12">
                <div class="col-span-4">
                  <InputLabel for="company" value="Company" />
                  <select
                    required
                    id="company"
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
            </form>

            <div class="flex items-center justify-center mt-4">
              <DangerButton
                class="ms-1 mr-4"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                @click="deleteInvestiment()"
              >
                Delete
              </DangerButton>

              <PrimaryButton
                class="ms-1"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                @click="updateInvestiment()"
              >
                Save
              </PrimaryButton>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
