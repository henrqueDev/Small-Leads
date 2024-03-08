<script setup>

    import Modal from '@/Components/Modal.vue';
    import { ref, onMounted} from 'vue'
    import { usePage } from '@inertiajs/vue3';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import InputError from '@/Components/InputError.vue';
    
    const props =  defineProps({
            show: {
                type: Boolean,
                default: () => false
            }
    });


    const companies = ref([]);

    const filter = ref({
        name: '',
        email: '',
        phone: '',
        company_id: null
    });

    const emit = defineEmits(['close', 'filter']);

    const filterAction = (params) => {
        emit('filter', params);
    }

    const closeModal =  () => {
        emit('close');
    };

    const fetchData = async () => {
    try {
        const response = await axios.get('/api/companies');
        companies.value = response.data;
    } catch (error) {
        console.error("Error fetching mineral log data:", error);
    }
    }

    onMounted(fetchData);

</script>

<template>
    <Modal :show="props.show" @close="closeModal">
        <div class="p-6">
                                <div class="mr-5">
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

            

                            <div class="mt-4">
                                
                            </div>

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
                                    <option v-for="company in companies" :value="company.id" :key="company.id">
                                        {{ company.name }} 
                                    </option>
                                </select>
                            
                            </div>

        </div>
        
        <button class="m-5 p-3 bg-white rounded-md" @click="closeModal()"> Cancel </button>
        
        <button class="m-5 p-3 bg-white rounded-md" @click="filterAction(filter)"> Filter </button>
    </Modal>
</template>


