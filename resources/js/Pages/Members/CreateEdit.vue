<script setup>
import PageLayout from '@/Layouts/PageLayout.vue'
import InputLabel from '@/Components/InputLabel.vue'
import InputError from '@/Components/InputError.vue'
import TextInput from '@/Components/TextInput.vue'
import { useForm, Link } from '@inertiajs/vue3'

const props = defineProps({
    member: Object,
    membershipPlans: Object,
})

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    phone: '',
    date_of_birth: '',
    height: '',
    weight: '',
    membership_plan_id: '',
    start_date: '',
})

const title = props.member ? 'Edit Member' : 'Add Member';

const submit = () => {
    if (props.member) {
        form.put(`/members/${props.member.id}`);
    } else {
        form.post('/members');
    }
}


if (props.member) {
    form.first_name = props.member.first_name;
    form.last_name = props.member.last_name;
    form.email = props.member.email;
    form.phone = props.member.phone;
    form.date_of_birth = props.member.date_of_birth;
    form.height = props.member.height;
    form.weight = props.member.weight;
    form.membership_plan_id = props.member.membership_plan_id;
    form.start_date = props.member.start_date;
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
                    <InputLabel value="First Name *" />
                    <TextInput v-model="form.first_name" placeholder="First Name" />
                    <InputError v-if="form.errors.first_name" :message="form.errors.first_name" />
                </div>

                <div class="mb-5">
                    <InputLabel value="Last Name *" />
                    <TextInput v-model="form.last_name" placeholder="Last Name" />
                    <InputError v-if="form.errors.last_name" :message="form.errors.last_name" />
                </div>

                <div class="mb-5">
                    <InputLabel value="Email *" />
                    <TextInput v-model="form.email" placeholder="Email" />
                    <InputError v-if="form.errors.email" :message="form.errors.email" />
                </div>

                <div class="mb-5">
                    <InputLabel value="Phone" />
                    <TextInput v-model="form.phone" placeholder="Phone" />
                    <InputError v-if="form.errors.phone" :message="form.errors.phone" />
                </div>

                <div class="mb-5">
                    <InputLabel value="Date of Birth" />
                    <TextInput v-model="form.date_of_birth" type="date" placeholder="Date of Birth" />
                    <InputError v-if="form.errors.date_of_birth" :message="form.errors.date_of_birth" />
                </div>

                <div class="mb-5">
                    <InputLabel value="Height *" />
                    <TextInput v-model="form.height" type="number" min=1 placeholder="Height" />
                    <InputError v-if="form.errors.height" :message="form.errors.height" />
                </div>

                <div class="mb-5">
                    <InputLabel value="Weight *" />
                    <TextInput v-model="form.weight" type="number" min=1 step="0.1" placeholder="Weight" />
                    <InputError v-if="form.errors.weight" :message="form.errors.weight" />
                </div>

                <div class="mb-5">
                    <InputLabel value="Membership Plan *" />
                    <select v-model="form.membership_plan_id" :class="[form.membership_plan_id === '' ? 'text-gray-500' : '']" class="block w-full rounded-md border-gray-300">
                        <option class="text-black" value="">- Select Membership Plan -</option>
                        <option v-for="membershipPlan in membershipPlans" class="text-black" :key="membershipPlan.id" :value="membershipPlan.id">
                            {{ membershipPlan.name }}
                        </option>
                    </select>
                    <InputError v-if="form.errors.membership_plan_id" :message="form.errors.membership_plan_id" />
                </div>

                <div class="mb-5">
                    <InputLabel value="Membership Start Date *" />
                    <TextInput type="date" v-model="form.start_date" placeholder="Membership Start Date" />
                    <InputError v-if="form.errors.start_date" :message="form.errors.start_date" />
                </div>

                <button :disabled="form.processing" class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-md shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-75 mr-4">
                    {{ props.member ? 'Save' : 'Create' }}
                </button>

                <Link :href="route('members.index')" class="px-6 py-3 bg-gray-300 text-gray-800 font-semibold rounded-md shadow-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-75">
                    Back
                </Link>
            </form>
        </div>
    </PageLayout>
</template>