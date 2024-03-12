<script setup>
import Modal from "@/Components/Modal.vue";
import { ref, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import CloseIcon from "@/Components/CloseIcon.vue";
import SecondaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import CheckBoxTagsFilter from "@/Pages/Lead/Partials/CheckBoxTagsFilter.vue";

const props = defineProps({
  show: {
    type: Boolean,
    default: () => false,
  },
  tags: {
    type: Array,
    default: () => [],
  },
  alreadySelectedTags: {
    type: Array,
  },
  headers: {
    type: Array,
    required: true,
  },
});

const companies = ref([]);

const filter = ref({
  name: "",
  email: "",
  phone: "",
  company_id: null,
  tags: props.alreadySelectedTags,
  situation:{
    converted: false,
    is_paying: false,
  },
  order: {
    orderBy: '',
    orderDesc: false,
  },
});

console.log(props.headers);

const emit = defineEmits(["close", "filter"]);

const filterAction = (params) => {
  console.log(params);
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

console.log(filter.value.tags);

const clearFilter = () => {
  filter.value = {
    name: "",
    email: "",
    phone: "",
    company_id: null,
    tags: [],
    situation: {
      converted: false,
      is_paying: false,
    },
    order: {
      orderBy: '',
      orderDesc: false,
    },
  };
};

const queryParams = (...args) => {
  let queryString = window.location.search;

  if (queryString.indexOf("?") === -1) {
    return {
      name: "",
      email: "",
      phone: "",
      company_id: null,
      tags: props.alreadySelectedTags,
      situation:{
        converted: false,
        is_paying: false,
      },
      order: {
        orderBy: '',
        orderDesc: false,
      },
    };
  }

  queryString = queryString.substring(queryString.indexOf("?") + 1);

  const updatedQuery = new URLSearchParams(queryString);

  let updatedFilter = {
    name: updatedQuery.get("filter[name]"),
    email: updatedQuery.get("filter[email]"),
    phone: updatedQuery.get("filter[phone]"),
    company_id: updatedQuery.get("filter[company_id]"),
    tags: props.alreadySelectedTags,
    situation: {
      converted: updatedQuery.get("filter[situation][converted]") == "true" ? true : false,
      is_paying: updatedQuery.get("filter[situation][is_paying]") == "true" ? true : false,
    },
    order: {
      orderBy: updatedQuery.get("filter[order][orderBy]"),
      orderDesc: updatedQuery.get("filter[order][orderDesc]") == "true" ? true : false,
    },
  };

  console.log(updatedQuery.get("filter[converted]") != "true" ? "oxi" : "ah");

  return updatedFilter;
};

const loadTagsSelected = (tagsSelected) => {
  console.log(tagsSelected);
  filter.value.tags = Object.entries(tagsSelected).map(([key, value]) => value);

  console.log(filter.value.tags);
};

onMounted(() => {
  fetchData();
  filter.value = queryParams();
});
</script>

<template>
  <Modal :show="props.show" @close="closeModal">
    <div class="w-full grid grid-cols-9 grid-rows-1 h-full justify-end">
      <h1
        class="m-5 p-3 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight col-span-8"
      >
        Leads Filter
      </h1>
      <button
        class="m-5 flex justify-center align-center col-span-1"
        @click="closeModal()"
      >
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
      <div class="mt-4 inline-flex">
        <div class="mr-5">
          <InputLabel for="company" value="Company" />
          <select
            id="company"
            class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
            v-model="filter.company_id"
          >
            <option value=""></option>
            <option v-for="company in companies" :value="company.id" :key="company.id">
              {{ company.name }}
            </option>
          </select>
          </div>
          <div class="inline-flex ml-5">
            <div class="mr-5  ">
            <InputLabel for="orderBy" value="Order by" />
            <select
              id="orderBy"
              class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
              v-model="filter.order.orderBy"
            >
              <option value=""></option>
              <option v-for="header in headers" :value="header.column" :key="header.column">
                {{ header.title }}
              </option>
            </select>
            </div>
            <div class="ml-5"> 
              <InputLabel for="orderDesc" value="Desc?" />

              <input
                id="orderDesc"
                type="checkbox"
                class="my-5 ml-3 h-5 py-3 px-3 leading-tight text-gray-500 bg-white rounded-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-700 dark:hover:bg-gray-700 dark:hover:text-gray"
                v-model="filter.order.orderDesc"
                autocomplete="orderDesc"
              />
            </div>

        </div>
        
      </div>

      <div class="mt-2 ml-3">
          <InputLabel for="tags" value="Tags" />
          <CheckBoxTagsFilter
            id="tags"
            @tagSelected="(tagsSelected) => loadTagsSelected(tagsSelected)"
            :tags="tags"
            :alreadySelectedTags="filter.tags"
          />
      </div>

      <div class="mt-4 inline-flex">
        <div class="mr-5">
          <InputLabel class="mt-1 block w-full" for="converted" value="Converted?" />

          <input
            id="converted"
            type="checkbox"
            class="my-5 ml-3 h-5 py-3 px-3 leading-tight text-gray-500 bg-white rounded-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-700 dark:hover:bg-gray-700 dark:hover:text-gray"
            v-model="filter.situation.converted"
            autocomplete="converted"
          />
        </div>
        <div class="ml-5">
          <InputLabel class="mt-1 block w-full" for="is_paying" value="Is paying?" />

          <input
            id="is_paying"
            type="checkbox"
            class="my-5 ml-3 h-5 py-3 px-3 leading-tight text-gray-500 bg-white rounded-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-700 dark:hover:bg-gray-700 dark:hover:text-gray"
            v-model="filter.situation.is_paying"
            autocomplete="is_paying"
          />
        </div>
      </div>
    </div>
    <div class="w-full grid grid-cols-8 grid-rows-1 h-full justify-end">
      <div class="col-span-4"></div>

      <button class="m-5 p-3 bg-white rounded-md col-span-2" @click="clearFilter()">
        Clear
      </button>

      <button
        class="m-5 p-3 bg-white rounded-md col-span-2"
        @click="filterAction(filter)"
      >
        Filter
      </button>
    </div>
  </Modal>
</template>
