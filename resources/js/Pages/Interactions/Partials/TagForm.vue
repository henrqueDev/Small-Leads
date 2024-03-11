<script setup>
const tagForm = useForm({
  name: "",
});

const showTagForm = ref(false);
</script>
<template>
  <span class="mx-3 space-x-2 p-5" v-if="showTagForm">
    <TextInput
      v-model="tagForm.name"
      class="inline-flex text-center text-xl bg-white border border-gray-200 rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700"
    ></TextInput>
  </span>
</template>
