<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { ref, onMounted, computed, watch, defineProps } from "vue";
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import CheckBoxDropDown from "@/Pages/Lead/Partials/CheckBoxDropDown.vue";
import AddIcon from "@/Components/AddIcon.vue";
const props = defineProps({
  tags: {
    type: Object,
    required: false,
  },
  lead: {
    type: Object,
    required: true,
  },
  leadTags: {
    type: Object,
    required: false,
  },
});

const companies = ref([]);
async function fetchData() {
  try {
    const response = await axios.get("/api/companies");
    companies.value = response.data;
  } catch (error) {
    console.error("Error fetching mineral log data:", error);
  }
}
const tags = ref(Object.entries(props.tags).map(([key, value]) => value));
console.log(tags.value);
const company_not_found = ref(false);
const form = useForm({
  id: props.lead.id,
  name: props.lead.name,
  last_name: props.lead.last_name,
  email: props.lead.email,
  phone: props.lead.phone,
  company_id: props.lead.company_id,
  new_company: "",
  tags: props.leadTags.map((leadTag) => {
    return leadTag.tag;
  }),
});

console.log(form.tags);
onMounted(fetchData);

watch(company_not_found, () => {
  if (company_not_found == true) {
    form.company_id = null;
  } else {
    form.new_company = "";
  }
});

const updateLead = () => {
  form.patch(route("leads.update", { lead: form.id }));
};

const toggleTagForm = () => {
  showTagForm.value = !showTagForm.value;
};

const loadTagsSelected = (tagsSelected) => {
  console.log(tagsSelected);
  form.tags = Object.entries(tagsSelected).map(([key, value]) => value);

  console.log(form.tags);
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
            <form @submit.prevent="updateLead()">
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
                  <InputLabel for="last_name" value="Last name" />

                  <TextInput
                    id="last_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.last_name"
                    required
                    autofocus
                    autocomplete="last_name"
                  />

                  <InputError class="mt-2" :message="form.errors.last_name" />
                </div>
              </div>

              <div class="mt-4"></div>

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
                <InputLabel for="phone" value="Phone" />

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
                <CheckBoxDropDown
                  @tagSelected="(tagsSelected) => loadTagsSelected(tagsSelected)"
                  :alreadySelectedTags="form.tags"
                  :tags="tags"
                />

                <div
                  v-for="tag in form.tags"
                  class="inline-flex border dark:border-white-500 bg-opacity-0 items-center ml-3 px-4 py-2 text-sm font-medium text-center text-white bg-blue-100 rounded-lg hover:bg-blue-100 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-1000 dark:hover:bg-white-500 dark:hover:text-gray-900 dark:focus:ring-blue-800"
                >
                  {{ tag.name }}
                </div>
              </div>

              <div class="mt-4 grid grid-cols-12">
                <div class="col-span-4">
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
                </div>
                <div class="col-span-3">
                  <label class="my-8" for="checkbox">Company not found?</label>
                  <input
                    class="my-5 ml-3 h-5 py-3 px-3 leading-tight text-gray-500 bg-white rounded-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-700 dark:hover:bg-gray-700 dark:hover:text-gray"
                    type="checkbox"
                    id="checkbox"
                    name="checkbox"
                    v-model="company_not_found"
                  />
                </div>
                <div class="col-span-5">
                  <InputLabel
                    class="mt-1 block w-full"
                    for="new_company"
                    value="Company name (if you not found it)"
                  />

                  <input
                    id="new_company"
                    type="text"
                    class="border-gray-300 dark:disabled:bg-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    :disabled="!company_not_found"
                    required
                    v-model="form.new_company"
                    autocomplete="new_company"
                  />
                </div>
              </div>

              <div class="mt-4"></div>

              <div class="flex items-center justify-center mt-4">
                <PrimaryButton
                  class="ms-1"
                  :class="{ 'opacity-25': form.processing }"
                  :disabled="form.processing"
                >
                  Save
                </PrimaryButton>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
