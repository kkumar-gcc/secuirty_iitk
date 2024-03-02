<script setup>
import CreateCommentForm from "@/Pages/Reports/Partials/CreateCommentForm.vue";
import Paginator from "@/Components/Paginator.vue";
import Avatar from "@/Components/Avatar.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DeleteCommentForm from "@/Pages/Reports/Partials/DeleteCommentForm.vue";
import UpdateCommentForm from "@/Pages/Reports/Partials/UpdateCommentForm.vue";

const props = defineProps({
    report: {
        type: Object,
    },
    comments: {
        type: Object,
    }
})
</script>

<template>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Comments ({{comments.total}})</h2>
    <div class="py-4">
        <CreateCommentForm :report="report"/>

        <div class="my-3">
            <div
                v-for="comment in comments.data"
                :key="comment.id"
                class="p-1 px-2 md:p-2.5 border group border-gray-200 relative mt-4 first:mt-0 w-full text-base text-left rounded-lg font-normal shadow-sm hover:shadow-md"
            >
                <header class="flex flex-row not-prose">
                    <div class="flex-1">
                        <div class="flex items-center space-x-4">
                            <Avatar :user="comment.user"/>
                            <div class="font-medium">
                                <span>
                                    {{ comment.user.name }}
                                </span>
                                <div class="text-sm">
                                    {{ comment.created_at }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="items-center justify-end hidden group-hover:flex"
                        v-if="can('edit own comments | edit all comments | delete own comments | delete all comments')"
                    >
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <span class="inline-flex rounded-md">
                                    <button
                                        class="inline-flex items-center px-3 py-3 border rounded-full text-sm leading-4 font-medium text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                        type="button"
                                    >
                                        {{ $page.props.auth.user.name.substring(0, 2).toUpperCase() }}
                                    </button>
                                </span>
                            </template>

                            <template #content>
                                <UpdateCommentForm :comment="comment" v-if="can('edit own comments | edit all comments')"/>
                                <DeleteCommentForm :comment="comment" v-if="can('delete own comments | delete all comments')"/>
                            </template>
                        </Dropdown>
                    </div>
                </header>
                <div class="my-3 prose max-w-none sm:max-w-full prose-img:rounded-xl prose-a:text-skin-600 ">
                    <div>
                        {{comment.body}}
                    </div>
                </div>
            </div>
            <Paginator :paginator="comments" />
        </div>
    </div>
</template>
