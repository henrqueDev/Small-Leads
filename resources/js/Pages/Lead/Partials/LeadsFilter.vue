<script setup>
import Modal from "@/Components/Modal.vue";
import { ref, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import CloseIcon from '@/Components/CloseIcon.vue'
import SecondaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";

const props = defineProps({
  show: {
    type: Boolean,
    default: () => false,
  },
});

const companies = ref([]);

const filter = ref({
  name: "",
  email: "",
  phone: "",
  company_id: null,
});

console.log(filter);

const emit = defineEmits(["close", "filter"]);

const filterAction = (params) => {
  emit("filter", params);
};

const closeModal = () => {
  emit("close");
};

const fetchData = async () => {
  try {
    const response = await axios.get("/api/companies");
    companies.value = response.data;
  } catch (error) {
    console.error("Error fetchData: ", error);
  }
};

const clearFilter = () => {
    filter.value = {
        name: "",
        email: "",
        phone: "",
        company_id: null,
    }
}

const queryParams = (...args) => {
  let queryString = window.location.search;

  if (queryString.indexOf("?") === -1) {
    return {};
  }

  queryString = queryString.substring(queryString.indexOf("?") + 1);
  console.log(queryString);
  let updatedQuery = new URLSearchParams(queryString);
  let updatedFilter = {
    name: updatedQuery.get("filter[name]"),
    email: updatedQuery.get("filter[email]"),
    phone: updatedQuery.get("filter[phone]"),
    company_id: updatedQuery.get("filter[company_id]"),
  };
  console.log();

  return updatedFilter;
};

onMounted(() => {
  fetchData();
  filter.value = queryParams();
});



</script>

<template>
  <Modal :show="props.show" @close="closeModal">
    <div class="w-full grid grid-cols-9 grid-rows-1 h-full justify-end " >
        
        <h1 class="m-5 p-3 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight col-span-8">Leads Filter</h1>
        <button class="m-5 flex justify-center align-center   col-span-1" @click="closeModal()">
            <CloseIcon class="w-full h-75" />
        </button>
    </div>
    
    <div class="p-6">
      <div class="mt-4">
        <InputLabel for="name" value="Name" />

        <TextInput
          id="name"
          type="text"
          class="mt-1 block w-full"
          v-model="filter.name"
          autofocus
          autocomplete="name"
        />
      </div>

      <div class="mt-4"></div>

      <div class="mt-4">
        <InputLabel for="email" value="Email" />

        <TextInput
          id="email"
          type="email"
          class="mt-1 block w-full"
          v-model="filter.email"
          autocomplete="new-email"
        />
      </div>

      <div class="mt-4">
        <InputLabel for="phone" value="Phone" />

        <TextInput
          id="phone"
          type="text"
          class="mt-1 block w-full"
          v-model="filter.phone"
          autofocus
          autocomplete="new-phone"
        />
      </div>

      <div class="mt-4">
        <InputLabel for="company" value="Company" />
        <select
          class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
          v-model="filter.company_id"
        >
          <option value=""></option>
          <option v-for="company in companies" :value="company.id" :key="company.id">
            {{ company.name }}
          </option>
        </select>
      </div>
    </div>
    <div class="w-full grid grid-cols-8 grid-rows-1 h-full justify-end ">
        <div class="col-span-4"></div>

        <button class="m-5 p-3 bg-white rounded-md col-span-2" @click="clearFilter()">Clear</button>

        <button class="m-5 p-3 bg-white rounded-md col-span-2" @click="filterAction(filter)">
            Filter
        </button>
    </div>
  </Modal>
</template>
