<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: Object,
    required: true,
});

const select = ref(null);

const options = 

onMounted(() => {
    if (select.value.hasAttribute('autofocus')) {
        select.value.focus();
    }
});

defineExpose({ focus: () => select.value.focus() });
</script>

<template>
    <select
        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
        v-model="model"
        ref="select"
    >
        <option v-for="option in options" :value="option.value">
            {{ option.text }}
        </option>
    </select>
</template>
