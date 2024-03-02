<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import DeleteReportForm from "@/Pages/Reports/Partials/DeleteReportForm.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DownloadReport from "@/Pages/Reports/Partials/DownloadReport.vue";
import Tag from "@/Components/Tag.vue";
import CreateRemarkForm from "@/Pages/Reports/Partials/CreateRemarkForm.vue";
import ViewRemarks from "@/Pages/Reports/Partials/ViewRemarks.vue";
import ViewComments from "@/Pages/Reports/Partials/ViewComments.vue";

defineProps({
    report: Object,
    remarks: Object,
    comments: Object,
});

const form = useForm({});

const approveReport = async (reportId) => {
    if (confirm('Are you sure you want to approve this report?')) {
        form.post(route('reports.approveOne', reportId), {
            preserveScroll: true,
            onSuccess: () => form.reset(),
            onFinish: () => form.reset(),
        });
    }
}
</script>

<template>
    <Head :title="report.serial_number"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-row">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Report - {{ report.serial_number }}</h2>
                <div v-if="report.approved" class="ml-2">
                    <Tag value="Approved" class="bg-green-100 text-green-800 border-green-400 hover:border-green-600"/>
                </div>
                <div class="flex-1 flex justify-end">
                    <CreateRemarkForm
                        :key="report.id" :report="report" class="ml-2"
                        v-if="can('create remarks')"
                    />
                    <DownloadReport :key="report.id" :report="report">
                        Download
                    </DownloadReport>
                    <SecondaryButton
                        @click="approveReport(report.id)"
                        class="ml-2"
                        v-if="can('approve reports') && !report.approved"
                    >
                        Approve
                    </SecondaryButton>
                    <SecondaryButton
                        :href="route('reports.edit', report.id)"
                        class="ml-2"
                        v-if="can('edit own reports | edit all reports') && !report.approved"
                    >
                        Edit Report
                    </SecondaryButton>
                    <DeleteReportForm
                        v-if="can('delete own reports | delete all reports') && !report.approved"
                        :key="report.id" :report="report" class="ml-2"/>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Report Details</h2>
                    <div>
                        <div class="py-4 grid grid-cols-2 gap-4">
                            <div class="flex flex-col">
                                <label class="block text-sm font-medium text-gray-700" for="title">Shift</label>
                                <div class="mt-1">
                                    <input id="title" :value="report.serial_number"
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                           name="title"
                                           readonly
                                           type="text">
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <label class="block text-sm font-medium text-gray-700"
                                       for="description">Description</label>
                                <div class="mt-1">
                                    <textarea id="description"
                                              class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                              name="description"
                                              readonly
                                              rows="3">{{ report.description }}</textarea>
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <label class="block text-sm font-medium text-gray-700" for="status">Status</label>
                                <div class="mt-1">
                                    <input id="status" :value="report.status"
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                           name="status"
                                           readonly
                                           type="text">
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <label class="block text-sm font-medium text-gray-700" for="venue">Venue</label>
                                <div class="mt-1">
                                    <input id="venue" :value="report.venue"
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                           name="venue"
                                           readonly
                                           type="text">
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <label class="block text-sm font-medium text-gray-700" for="reporter">Reporter</label>
                                <div class="mt-1">
                                    <input id="reporter" :value="report.reporter"
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                           name="reporter"
                                           readonly
                                           type="text">
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <label class="block text-sm font-medium text-gray-700" for="reporter">Tags</label>
                                <div class="mt-1">
                                    <template v-for="tag in report.tags">
                                        <Tag :value="tag.title" />
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="report.attachments.length>0" class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Report Attachments</h2>
                    <div class="py-4 grid grid-cols-4 gap-4">
                        <template v-for="attachment in report.attachments">
                            <div
                                class="border shadow sm:rounded-lg bg-white"
                            >
                                <img :alt="'preview of '+attachment.name" :src="attachment.path"
                                     class="w-full h-32 object-cover"/>
                                <div class="p-4 border-t">
                                    <div class="flex justify-between">
                                        <div class="flex-1">
                                            <h2 class="text-base font-medium text-gray-900">{{ attachment.name }}</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg" v-if="remarks.data && remarks.data.length>0">
                    <ViewRemarks :remarks="remarks"/>
                </div>
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <ViewComments :comments="comments" :report="report"/>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

