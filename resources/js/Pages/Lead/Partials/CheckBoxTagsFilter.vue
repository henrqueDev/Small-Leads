<script setup>
import { ref, defineProps, watch } from "vue";

const props = defineProps({
  tags: {
    type: Array,
    required: false,
  },
  alreadySelectedTags: {
    type: Array,
  },
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
const emit = defineEmits(["newSearch", "tagSelected"]);

const handleSearch = () => {
  let entries = props.tags;
  //let entries = Object.entries(props.tags);
  //console.log(entries[0][1]);
  tagsFiltered.value = entries.filter((tag) =>
    tag.name.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
  console.log(tagsFiltered.value);
  emit("newSearch", tagsFiltered.value);
};

watch(tagsSelected, () => {
  let entries = props.tags;

  /*tagsFiltered.value = entries.filter((tag) =>
    tag.name.toLowerCase().includes(searchQuery.value.toLowerCase())
  );*/
  console.log(tagsFiltered.value);
  emit("tagSelected", tagsSelected.value);
});
watch(searchQuery, handleSearch);
</script>

<template>
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

  <div v-show="isOpen" class="z-10 bg-white rounded-lg shadow w-60 dark:bg-gray-700">
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
            v-model="tagsSelected"
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
</template>
