<script setup>
import PageLayout from '@/Layouts/PageLayout.vue'
import { Link, router } from '@inertiajs/vue3'

defineProps({
    members: Array,
})
</script>

<template>
    <PageLayout title="Members">
        <div class="flex justify-between items-center bg-gray-100 p-4 rounded-t-md">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Members
            </h2>

            <Link
                href="/members/create"
                class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-75"
            >
                + Add Member
            </Link>
        </div>
        <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
            <table class="w-full text-sm text-left rtl:text-right text-body">
                <thead class="text-sm text-body bg-neutral-secondary-soft border-b rounded-base border-default">
                    <tr>
                        <th scope="col" class="px-3 py-3 font-medium">
                            Member Name
                        </th>
                        <th scope="col" class="px-3 py-3 font-medium">
                            Email
                        </th>
                        <th scope="col" class="px-3 py-3 font-medium">
                            Membership Plan
                        </th>
                        <th scope="col" class="px-3 py-3 font-medium">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="member in members" :key="member.id">
                        <td class="px-3 py-3">{{ member.first_name }} {{ member.last_name }}</td>
                        <td class="px-3 py-3">{{ member.email }}</td>
                        <td class="px-3 py-3">{{ member.membership_plan.name }}<span v-if="member.membership_plan.deleted_at" class="text-red-600"> (Deleted)</span></td>
                        <td class="px-3 py-3">
                            <Link :href="`/members/${member.id}/edit`">Edit</Link>
                            |
                            <button
                                @click="router.delete(`/members/${member.id}`)"
                                class="text-red-600"
                            >
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </PageLayout>
</template>
