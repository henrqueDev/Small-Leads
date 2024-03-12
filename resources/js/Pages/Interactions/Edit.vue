<script setup>
import Swal from "sweetalert2";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextArea from "@/Components/TextArea.vue";
import { ref, onMounted, computed, watch, defineProps } from "vue";
import { Head, Link, useForm, usePage, router } from "@inertiajs/vue3";
import CheckBoxDropDown from "@/Pages/Lead/Partials/CheckBoxDropDown.vue";
import AddIcon from "@/Components/AddIcon.vue";
import DangerButton from '@/Components/DangerButton.vue';
import TextInput from "@/Components/TextInput.vue";
import DateInput from "@/Components/DateInput.vue";

const props = defineProps({
  lead: {
    type: Object,
    required: true,
  },
  interaction: {
    type: Object,
    required: true,
  },
  interaction_types: {
    type: Array,
    required: true,
  },
});

console.log(props.lead);

const lead = ref(props.lead);
const interaction_type_not_found = ref(false);

const form = useForm({
  id: props.interaction.id,
  description: props.interaction.description,
  event_date: props.interaction.event_date,
  interaction_type_id: props.interaction.interaction_type_id,
  new_interaction_type: "",
  lead_id: props.interaction.lead_id,
});

watch(interaction_type_not_found, () => {
  if (interaction_type_not_found.value == true) {
    form.interaction_type_id = null;
    console.log("CAIU");
  } else {
    form.new_interaction_type = "";
  }
});

const submit = () => {
  form.patch(route("interactions.update", { interaction: form.id }));
};

const deleteInteraction = () => {
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
        router.delete(route("interactions.destroy", { interaction: form.id }));
      }
    });
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
                <TextArea
                  required
                  id="description"
                  type="text"
                  class="mt-1 block w-full"
                  v-model="form.description"
                  autofocus
                  autocomplete="description"
                />

                <InputError class="mt-2" :message="form.errors.description" />
              </div>

              <div class="mt-4"></div>

              <div class="mt-4">
                <div class="inline-flex">
                  <div>
                    <InputLabel for="lead" value="Lead" />
                    <select
                      id="lead"
                      :disabled="true"
                      class="w-75 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mr-5"
                      v-model="form.lead_id"
                    >
                      <option :value="lead.id" :key="lead.id">
                        {{ lead.name }}
                      </option>
                    </select>
                  </div>
                  <div>
                    <InputLabel for="event_date" value="Event date" />
                    <DateInput
                      required
                      type="date"
                      id="event_date"
                      v-model="form.event_date"
                    />

                    <InputError class="mt-2" :message="form.errors.event_date" />
                  </div>
                </div>
              </div>
              <div class="mt-4 grid grid-cols-12">
                <div class="col-span-3">
                  <InputLabel for="interaction_type" value="Interaction type" />
                  <select
                    id="interaction_type"
                    :disabled="interaction_type_not_found"
                    required
                    class="w-75 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    v-model="form.interaction_type_id"
                  >
                    <option
                      v-for="interaction_type in interaction_types"
                      :key="interaction_type.id"
                      :value="interaction_type.id"
                    >
                      {{ interaction_type.name }}
                    </option>
                  </select>
                  <InputError class="mt-2" :message="form.errors.interaction_type_id" />
                </div>
                <div class="col-span-4">
                  <label class="my-8" for="checkbox">Interaction type not found?</label>
                  <input
                    class="my-5 ml-3 h-5 py-3 px-3 leading-tight text-gray-500 bg-white rounded-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-700 dark:hover:bg-gray-700 dark:hover:text-gray"
                    type="checkbox"
                    id="checkbox"
                    name="checkbox"
                    v-model="interaction_type_not_found"
                  />
                </div>
                <div class="col-span-5">
                  <InputLabel
                    class="mt-1 block w-full"
                    for="new_interaction_type"
                    value="Interaction type name (if you not found it)"
                  />

                  <input
                    id="new_interaction_type"
                    type="text"
                    class="border-gray-300 dark:disabled:bg-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    :disabled="!interaction_type_not_found"
                    required
                    v-model="form.new_interaction_type"
                    autocomplete="new_interaction_type"
                  />

                  <InputError class="mt-2" :message="form.errors.new_interaction_type" />
                </div>
              </div>

              <div class="mt-4"></div>
              
            </form>
            <div class="flex items-center justify-center mt-4">
              <DangerButton
                  class="ms-1 mr-4"
                  :class="{ 'opacity-25': form.processing }"
                  :disabled="form.processing"
                  @click="deleteInteraction()"
                >
                  Delete
                </DangerButton>

                <PrimaryButton
                  class="ms-1"
                  :class="{ 'opacity-25': form.processing }"
                  :disabled="form.processing"
                  @click="submit()"
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
