<script setup>
import Swal from "sweetalert2";
import { ref, onMounted, computed, inject, watch } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, usePage, router, useForm } from "@inertiajs/vue3";
import NavLink from "@/Components/NavLink.vue";
import TextInput from "@/Components/TextInput.vue";
import TablePaginationFooter from "@/Components/TablePaginationFooter.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TagIcon from '@/Components/TagIcon.vue';

const props = defineProps({
  tags: {
    type: Object,
  },
});

const tagsHeaders = ["Tag", "Actions"];

const showFilter = ref(false);
const showEdit = ref(null);
const showCreate = ref(false);

const sortBy = ref("Name");
const sortDesc = ref(false);

const showFilterAction = () => {
  showFilter.value = true;
};

const tagsLive = ref(props.tags.data);

const createForm = useForm({
  name: ''
})


const editForm = useForm({
  id: null,
  name: "",
});

const filterMethod = (filter) => {
  router.get(route("tags.list"), {
    filter: filter,
  });
};

const toggleEdit = (tag) => {
  showEdit.value != tag.id ? (showEdit.value = tag.id) : (showEdit.value = 0);
  editForm.id = tag.id;
  editForm.name = tag.name;
};

const toggleCreate = (tag) => {
  showEdit.value = null;
  showCreate.value = !showCreate.value;
};

const createTag = async () => {
  await createForm.post(route("tags.store"));
  Swal.fire({
   position: "top-end",
              icon: 'success',
              title: `Tag created sucessfully`,
              showConfirmButton: false,
              timer: 1500
  });
}

const editTag = async () => {
  await editForm.patch(route("tags.update", { tag: editForm.id }));
  showEdit.value = 0;
  /*
  */
};

const deleteTag = (tag) => {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it!",
    cancelButtonText: "No, cancel!",
    reverseButtons: true
  }).then((result) => {
    if (result.isConfirmed) {
      router.delete(route("tags.destroy", { tag: tag.id }));
      Swal.fire({
        position: "top-end",
                    icon: 'success',
                    title: `Tag ${tag.name} deleted!`,
                    showConfirmButton: false,
                    timer: 1500
        })
    }
  });
  
};
</script>

<template>
  <AuthenticatedLayout>
    <Head title="tags" />
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 taging-tight">
        Tags
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="w-full grid grid-cols-9 grid-rows-1 h-full justify-end">
            <h2
              class="m-5 p-3 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight col-span-8"
            >
              Tags
            </h2>
            
            <button class="m-3  text-md col-span-1 p-3 text-gray-300 bg-gray-900 p-3  hover:bg-gray-700 duration-150 ease-in-out rounded-xl" @click="toggleCreate()">
             
              <TagIcon class="mt-3 text-center w-full " />
              <span class="text-xs">Create tag</span>
            </button>

          </div>
          <div class="m-5" v-if="showCreate == true">
                      <InputLabel for="new_tag_name" value="New tag name"></InputLabel>
                      <TextInput
                        id="new_tag_name"
                        v-model="createForm.name"
                        class="text-center text-xl bg-white border border-gray-200 rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-800"
                      ></TextInput>
                      <button
                        class="ml-2 p-3 bg-green-600 rounded-md col-span-2 hover:bg-green-600 duration-150 ease-in-out"
                        @click="createTag()"
                      >
                        Create
                      </button>
          </div>
          <div class="p-3 text-gray-900 dark:text-gray-100">
            <table
              class="w-full border border-separate border-gray-200 dark:border-gray-700 rounded-md p-2"
            >
              <thead>
                <tr
                  class="font-semibold text-xl text-gray-800 dark:text-gray-200 taging-tight"
                >
                  <th class="px-4 py-2 text-start" v-for="header in tagsHeaders"></th>
                </tr>
              </thead>
              <tbody>
                <tr
                  class="grid grid-cols-8 grid-rows-1 mb-5"
                  v-for="(tag, i) in tags.data"
                  :key="i"
                >
                  <td class="mt-5 text-start ml-1 col-span-6">
                    <span
                      class="border dark:border-white-500 cursor-pointer bg-opacity-0 m-3 px-4 text-md font-medium text-start text-white bg-blue-100 rounded-lg outline-none hover:bg-blue-100 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-1000 dark:hover:bg-white-500 dark:hover:text-gray-900 dark:focus:ring-blue-800 duration-150 ease-in-out"
                    >
                      {{ tag.name }}
                    </span>
                    <div class="mt-3" v-if="showEdit == tag.id">
                      <InputLabel for="new_tag_name" value="New tag name"></InputLabel>
                      <TextInput
                        id="new_tag_name"
                        v-model="editForm.name"
                        class="text-center text-xl bg-white border border-gray-200 rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-800"
                      ></TextInput>
                      <button
                        class="ml-2 p-3 bg-green-600 rounded-md col-span-2 hover:bg-green-600 duration-150 ease-in-out"
                        @click="editTag()"
                      >
                        Save
                      </button>
                    </div>
                  </td>
                  <td class="mt-2 col-span-2">
                    <button
                      class="p-3 bg-gray-900 rounded-md col-span-2 hover:bg-gray-700 duration-150 ease-in-out"
                      @click="toggleEdit(tag)"
                    >
                      Edit
                    </button>

                    <button
                      class="ml-2 p-3 bg-gray-900 text-red-500 rounded-md col-span-2 hover:bg-gray-700 duration-150 ease-in-out"
                      @click="deleteTag(tag)"
                    >
                      Delete
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
