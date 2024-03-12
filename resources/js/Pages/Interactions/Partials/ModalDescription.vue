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
  description: {
    type: String,
    default: () => ""
  }
});

const emit = defineEmits(["close"]);

const closeModal = () => {
  emit("close");
};

</script>

<template>
  <Modal :show="props.show" @close="closeModal">
  <div class="w-full grid grid-cols-9 grid-rows-1 h-full justify-end">
      <h1
        class="m-5 p-3 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight col-span-8"
      >
        Description
      </h1>
      <button
        class="m-5 flex justify-center align-center col-span-1"
        @click="closeModal()"
      >
        <CloseIcon class="w-full h-75" />
      </button>
    </div>
  <article class="m-5 p-3 font-semibold text-md text-gray-800 dark:text-gray-200 leading-tight ">
    <p class="break-words">{{props.description}}</p>
  </article>
  </Modal>
</template>
