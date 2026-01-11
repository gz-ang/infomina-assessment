<script setup>
import PageLayout from '@/Layouts/PageLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { ref, watch } from 'vue'
import TextInput from '@/Components/TextInput.vue'
import Modal from '@/Components/Modal.vue'
import DangerButton from '@/Components/DangerButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'

const currentDate = new Date();
const props = defineProps({
    members: Object,
    filters: Object,
})
const search = ref(props.filters.search || '')
const showDeleteModal = ref(false)
const memberToDelete = ref(null)

function confirmDelete(member) {
    memberToDelete.value = member
    showDeleteModal.value = true
}

function closeModal() {
    showDeleteModal.value = false
    memberToDelete.value = null
}

function deleteMember() {
    router.delete(
        route('members.destroy', memberToDelete.value.id),
        {
            onSuccess: () => closeModal(),
        }
    )
}

function submitSearch() {
    router.get(
        route('members.index'),
        { search: search.value },
        {
            preserveState: true,
            replace: true,
        }
    )
}

function clearSearch() {
    search.value = ''
    submitSearch()
}

function getStatus(member) {
    const start_date = new Date(member.start_date);
    const end_date = new Date(member.end_date);

    if (start_date > currentDate) {
        return '<span class="text-yellow-600">Inactive</span>';
    } else if (end_date < currentDate) {
        return '<span class="text-red-600">Expired</span>';
    } else {
        return '<span class="text-green-600">Active</span>';
    }
}

</script>

<template>
    <PageLayout title="Members">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center bg-gray-100 p-4 rounded-t-md">
            <div class="flex justify-between items-center mb-2 md:mb-0">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Members <span class="text-gray-600">({{ props.members.total }})</span>
                </h2>
                <Link
                    href="/members/create"
                    class="md:hidden px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-75"
                >
                    +
                </Link>
            </div>

            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                
                <div class="flex justify-start md:justify-around items-center gap-2 md:mr-4">
                    <TextInput
                        v-model="search"
                        placeholder="Search"
                        @keyup.enter="submitSearch"
                        class="w-full"
                    />
                    <button
                        @click="submitSearch"
                        class="rounded bg-white px-3 py-2 hover:bg-gray-300"
                    >
                        🔍
                    </button>
                    <button
                        @click="clearSearch"
                        class="rounded bg-white px-3 py-2 hover:bg-gray-300"
                    >
                        🗙
                    </button>
                </div>
                
                <Link
                    href="/members/create"
                    class="hidden md:block px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-75"
                >
                    New Member
                </Link>
            </div>
        </div>
        <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
            <table class="w-full text-sm text-left rtl:text-right text-body">
                <thead class="text-sm text-body bg-neutral-secondary-soft border-b rounded-base border-default">
                    <tr>
                        <th scope="col" class="px-3 py-3 font-medium">
                            Member Name
                        </th>
                        <th scope="col" class="px-3 py-3 font-medium hidden md:table-cell">
                            Email
                        </th>
                        <th scope="col" class="px-3 py-3 font-medium hidden md:table-cell">
                            Membership Plan
                        </th>
                        <th scope="col" class="px-3 py-3 font-medium hidden md:table-cell">
                            Membership Starts
                        </th>
                        <th scope="col" class="px-3 py-3 font-medium hidden md:table-cell">
                            Membership Ends
                        </th>
                        <th scope="col" class="px-3 py-3 font-medium hidden md:table-cell">
                            Status
                        </th>
                        <th scope="col" class="px-3 py-3 font-medium">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="props.members.total > 0" v-for="member in props.members.data" :key="member.id">
                        <td class="px-3 py-3">{{ member.first_name }} {{ member.last_name }}</td>
                        <td class="px-3 py-3 hidden md:table-cell">{{ member.email }}</td>
                        <td class="px-3 py-3 hidden md:table-cell">{{ member.membership_plan.name }}<span v-if="member.membership_plan.deleted_at" class="text-red-600"> (Deleted)</span></td>
                        <td class="px-3 py-3 hidden md:table-cell">{{ member.start_date }}</td>
                        <td class="px-3 py-3 hidden md:table-cell">{{ member.end_date }}</td>
                        <td class="px-3 py-3 hidden md:table-cell">
                            <span v-html="getStatus(member)"></span>
                        </td>
                        <td class="px-3 py-3">
                            <Link :href="`/members/${member.id}/edit`"><span class="md:hidden">View/</span>Edit</Link>
                            |
                            <button
                                @click="confirmDelete(member)"
                                class="text-red-600"
                            >
                                Delete
                            </button>
                        </td>
                    </tr>
                    <tr v-else>
                        <td colspan="7" class="px-3 py-3 text-center">No data available</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="w-full flex justify-center mb-4">
                <div class="mt-6 flex flex-wrap gap-1">
                    <template v-for="link in members.links" :key="link.label">
                        <Link
                            v-if="link.url"
                            :href="link.url"
                            v-html="link.label"
                            class="rounded px-3 py-1 text-sm hover:bg-gray-200"
                            :class="{ 'bg-gray-800 text-white': link.active }"
                            preserve-scroll
                        />

                        <span
                            v-else
                            v-html="link.label"
                            class="rounded px-3 py-1 text-sm text-gray-400 cursor-not-allowed"
                        />
                    </template>
                </div>
            </div>
    </PageLayout>
    <Modal
        :show="showDeleteModal"
        maxWidth="md"
        @close="closeModal"
    >
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Confirm Delete
            </h2>

            <p class="mt-2 text-sm text-gray-600">
                Are you sure you want to delete <strong>{{ memberToDelete.first_name }} {{ memberToDelete.last_name }}</strong>? This action cannot be undone.
            </p>

            <div class="mt-6 flex justify-end space-x-3">
                <SecondaryButton @click="closeModal">
                    Cancel
                </SecondaryButton>

                <DangerButton @click="deleteMember">
                    Delete
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>
