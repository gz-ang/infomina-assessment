<script setup>
import PageLayout from '@/Layouts/PageLayout.vue'
import InputLabel from '@/Components/InputLabel.vue'
import InputError from '@/Components/InputError.vue'
import TextInput from '@/Components/TextInput.vue'
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
    membership_plan: Array,
})

const form = useForm({
    name: '',
    description: '',
    price: 0,
    validity_type: '',
    validity: '',
})

const validityTypes = [
    { value: '', label: '- Select Validity Type -' },
    { value: 'day', label: 'Day' },
    { value: 'week', label: 'Week' },
    { value: 'month', label: 'Month' },
    { value: 'year', label: 'Year' },
]

if (props.membership_plan) {
    form.name = props.membership_plan.name;
    form.description = props.membership_plan.description;
    form.price = props.membership_plan.price;
    form.validity_type = props.membership_plan.validity_type;
    form.validity = props.membership_plan.validity;
}

const title = props.membership_plan ? 'Edit Membership Plan' : 'Add Membership Plan';

const submit = () => {
    if (props.membership_plan) {
        form.put(`/membership-plans/${props.membership_plan.id}`);
    } else {
        form.post('/membership-plans');
    }
}


</script>

<template>
    <PageLayout :title="title">
        <div class="flex justify-start items-center mb-4">
            <h1 class="text-2xl font-bold leading-tight text-gray-800">
                {{ title }}
            </h1>
        </div>
        <div class="inline-block">
            <form @submit.prevent="submit" class="max-w-sm mx-auto">
                <div class="mb-5">
                    <InputLabel value="Name" />
                    <TextInput v-model="form.name" placeholder="Name" />
                    <InputError v-if="form.errors.name" :message="form.errors.name" />
                </div>

                <div class="mb-5">
                    <InputLabel value="Description" />
                    <TextInput v-model="form.description" placeholder="Description" />
                    <InputError v-if="form.errors.description" :message="form.errors.description" />
                </div>

                <div class="mb-5">
                    <InputLabel value="Price" />
                    <TextInput v-model="form.price" type="number" placeholder="Price" />
                    <InputError v-if="form.errors.price" :message="form.errors.price" />
                </div>                

                <div class="mb-5">
                    <InputLabel value="Validity Type" />
                    <select v-model="form.validity_type" :class="[form.validity_type === '' ? 'text-gray-500' : '']" class="block w-full rounded-md border-gray-300">
                        <option v-for="validityType in validityTypes" class="text-black" :key="validityType.value" :value="validityType.value">
                            {{ validityType.label }}
                        </option>
                    </select>
                    <InputError v-if="form.errors.validity_type" :message="form.errors.validity_type" />
                </div>

                <div class="mb-5">
                    <InputLabel value="Validity" />
                    <TextInput v-model="form.validity" type="number" placeholder="Validity" />
                    <InputError v-if="form.errors.validity" :message="form.errors.validity" />
                </div>

                <button :disabled="form.processing" class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-md shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-75">
                    {{ props.membership_plan ? 'Save' : 'Create' }}
                </button>
            </form>
        </div>
    </PageLayout>
</template>