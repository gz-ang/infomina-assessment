<script setup>
import PageLayout from '@/Layouts/PageLayout.vue'
import InputError from '@/Components/InputError.vue'
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
    member: Array,
    membershipPlans: Array,
})

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    membership_plan_id: '',
})

if (props.member) {
    form.first_name = props.member.first_name;
    form.last_name = props.member.last_name;
    form.email = props.member.email;
    form.membership_plan_id = props.member.membership_plan_id;
}

const title = props.member ? 'Edit Member' : 'Add Member';

const submit = () => {
    if (props.member) {
        form.put(`/members/${props.member.id}`);
    } else {
        form.post('/members');
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
                    <label for="first-name" class="block mb-2.5 text-sm font-medium text-heading">First Name</label>
                    <input v-model="form.first_name" class="block w-full rounded-md px-3 py-2.5 shadow-xs placeholder:text-body" placeholder="First Name" />
                    <InputError v-if="form.errors.first_name" :message="form.errors.first_name" />
                </div>

                <div class="mb-5">
                    <label for="last-name" class="block mb-2.5 text-sm font-medium text-heading">Last Name</label>
                    <input v-model="form.last_name" class="block w-full rounded-md px-3 py-2.5 shadow-xs placeholder:text-body" placeholder="Last Name" />
                    <InputError v-if="form.errors.last_name" :message="form.errors.last_name" />
                </div>

                <div class="mb-5">
                    <label for="email" class="block mb-2.5 text-sm font-medium text-heading">Email</label>
                    <input type="email" v-model="form.email" class="block w-full rounded-md px-3 py-2.5 shadow-xs placeholder:text-body" placeholder="Email" />
                    <InputError v-if="form.errors.email" :message="form.errors.email" />
                </div>

                <div class="mb-5">
                    <label for="membership-plan-id" class="block mb-2.5 text-sm font-medium text-heading">Membership Plan</label>
                    <select v-model="form.membership_plan_id" class="block w-full rounded-md border-gray-300">
                        <option v-for="membershipPlan in membershipPlans" :key="membershipPlan.id" :value="membershipPlan.id">
                            {{ membershipPlan.name }}
                        </option>
                    </select>
                    <InputError v-if="form.errors.membership_plan_id" :message="form.errors.membership_plan_id" />
                </div>

                <button :disabled="form.processing" class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-md shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-75">
                    {{ props.member ? 'Save' : 'Create' }}
                </button>
            </form>
        </div>
    </PageLayout>
</template>