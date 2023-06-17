<template>
    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="container mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:text-white dark:bg-gray-800 overflow-hidden shadow-md shadow-indigo-500/20 w-full sm:rounded-lg relative">
                    <Link :href="route('blog.post.edit', post.slug)" v-if="$attrs.canEditPost" class="absolute right-5 top-5 bg-indigo-500 p-3 text-white rounded-full animate-pulse">
                        <Icon :path="mdiPencil" />
                    </Link>
                    <div class="rounded-lg text-4xl grow flex flex-col gap-4">
                        <img :src="post.thumbnail" :alt="post.title" class="aspect-video rounded object-cover object-center h-96" />
                        <h3 class="p-6">
                        {{ post.title }}
                        </h3>
                    </div>
                </div>
                <div class="post-content" v-html="marked(post.body)"></div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
    import AppLayout from '@/Layouts/AppLayout.vue'
    import { mdiPencil } from '@mdi/js'
    import { marked } from 'marked';

    import {
        router
    } from '@inertiajs/vue3'

    defineProps({
        post: Object
    })
</script>

<style scoped>

</style>
