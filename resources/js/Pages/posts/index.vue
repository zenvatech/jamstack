<template>
    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Blog
            </h2>
        </template>

        <div class="py-12">
            <div class="container mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl w-full sm:rounded-lg">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                        <div class="rounded p-4 dark:text-white cursor-pointer" v-for="post in posts.data" @click="router.visit(route( 'blog.post.show', { post } ))">
                            <div class="bg-gray-400 aspect-[4/3]  rounded-lg overflow-hidden">
                                <img :src="post.thumbnail" :alt="post.title" class="w-full h-full object-cover object-center" />
                            </div>

                            <div class="px-2">
                                <h3 class="text-lg">
                                    {{ post?.excerpt }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl w-full sm:rounded-lg flex gap-4 mt-4 p-4 justify-end">
                    <Link :href="link.url" :preserveState="true" :class="['p-2 font-bold', { 'text-indigo-500': link.active && link.url, 'text-white': link.url && !link.active, 'text-gray-500 cursor-not-allowed': !link.url } ]" :disabled="!link.url" v-for="link in posts.links" v-html="link.label" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue'
import { router, Link } from '@inertiajs/vue3'

defineProps({
  posts: Array
})
</script>

<style scoped>

</style>
