<script setup>
import Modal from "@/Components/Modal.vue";
import { ref, onMounted, getCurrentInstance, defineProps, watch } from "vue";
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
  companies: {
    type: Array,
  },
  headers: {
    type: Array,
    required: true,
  },
});

const selectedTags = ref(props.alreadySelectedTags);

const filter = ref({
  name: "",
  email: "",
  phone: "",
  company_id: null,
  tags: props.alreadySelectedTags,
  situation: {
    converted: false,
    is_paying: false,
  },
  order: {
    orderBy: "",
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
      orderBy: "",
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
      situation: {
        converted: false,
        is_paying: false,
      },
      order: {
        orderBy: "",
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
      converted:
        updatedQuery.get("filter[situation][converted]") == "true" ? true : false,
      is_paying:
        updatedQuery.get("filter[situation][is_paying]") == "true" ? true : false,
    },
    order: {
      orderBy: updatedQuery.get("filter[order][orderBy]"),
      orderDesc: updatedQuery.get("filter[order][orderDesc]") == "true" ? true : false,
    },
  };
  return updatedFilter;
};

const loadTagsSelected = (tagsSelected) => {
  console.log(tagsSelected);

  console.log(filter.value.tags);
};

onMounted(() => {
  filter.value = queryParams();
});

const isOpen = ref(false);
console.log(props.alreadySelectedTags);
const tagsSelected = ref(props.alreadySelectedTags);
const searchQuery = ref("");
const tagsFiltered = ref(props.tags);

console.log(tagsSelected.value);

const toggleDropdown = () => {
  isOpen.value = !isOpen.value;
};
const handleSearch = () => {
  let entries = props.tags;
  //let entries = Object.entries(props.tags);
  //console.log(entries[0][1]);
  tagsFiltered.value = entries.filter((tag) =>
    tag.name.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
  console.log(tagsFiltered.value);
};

watch(tagsSelected, () => {
  let entries = props.tags;

  /*tagsFiltered.value = entries.filter((tag) =>
    tag.name.toLowerCase().includes(searchQuery.value.toLowerCase())
  );*/
  filter.value.tags = Object.entries(tagsSelected).map(([key, value]) => value);
  console.log(filter.value.tags);
  //console.log(tagsFiltered.value);
  //emit("tagSelected", tagsSelected.value);
});
watch(searchQuery, handleSearch);
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
            <option
              v-for="company in props.companies"
              :value="company.id"
              :key="company.id"
            >
              {{ company.name }}
            </option>
          </select>
        </div>
        <div class="inline-flex ml-5">
          <div class="mr-5">
            <InputLabel for="orderBy" value="Order by" />
            <select
              id="orderBy"
              class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
              v-model="filter.order.orderBy"
            >
              <option value=""></option>
              <option
                v-for="header in headers"
                :value="header.column"
                :key="header.column"
              >
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

      <div v-if="!clearing" class="mt-2 mb-4">
        <!--
          <CheckBoxTagsFilter
            id="tags"
            @tagSelected="(tagsSelected) => loadTagsSelected(tagsSelected)"
            :tags="tags"
            :alreadySelectedTags="filter.tags"
          />
          -->
        <button
          :class="{ active: isOpen }"
          @click="toggleDropdown"
          class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-gray-700 rounded-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800"
          type="button"
        >
          Tags
          <svg
            class="w-2.5 h-2.5 ms-2.5"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 10 6"
          >
            <path
              stroke="currentColor"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="m1 1 4 4 4-4"
            />
          </svg>
        </button>

        <div
          v-show="isOpen"
          class="z-10 bg-white rounded-lg shadow w-60 dark:bg-gray-700"
        >
          <div class="p-3">
            <label for="input-group-search" class="sr-only">Search</label>
            <div class="relative">
              <div
                class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none"
              >
                <svg
                  class="w-4 h-4 text-gray-500 dark:text-gray-400"
                  aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 20 20"
                >
                  <path
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                  />
                </svg>
              </div>
              <input
                type="text"
                id="input-group-search"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Search tag"
                v-model="searchQuery"
              />
            </div>
          </div>
          <ul
            class="h-40 px-3 overflow-y-auto text-sm text-gray-700 dark:text-gray-200"
            aria-labelledby="dropdownSearchButton"
          >
            <li v-for="tag in tagsFiltered">
              <div
                class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600"
              >
                <input
                  :id="'checkbox-tag-' + tag.id"
                  type="checkbox"
                  :value="tag.id"
                  v-model="filter.tags"
                  class="w-4 h-4 block text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                />
                <label
                  :for="'checkbox-tag-' + tag.id"
                  class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300"
                  >{{ tag.name }}</label
                >
              </div>
            </li>
          </ul>
          <a
            :href="route('tags.list')"
            class="flex items-center p-3 text-sm font-medium text-gray-300 border-t border-gray-200 rounded-b-lg bg-gray-50 dark:border-gray-600 hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white-500 hover:underline"
          >
            <svg
              class="w-4 h-4 me-2"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              fill="currentColor"
              viewBox="0 0 20 18"
            >
              <path
                d="M6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Zm11-3h-6a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2Z"
              />
            </svg>
            Edit Tags
          </a>
        </div>
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
