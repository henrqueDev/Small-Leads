<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    leads: {
        type: Array
    }
});

const getUsers = this.$inertia.get('/companies');
console.log(getUsers);



/*
const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
*/
</script>

<template>
    <Head title="Leads" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Lead</h2>
        </template>

    

    </AuthenticatedLayout>
</template>
