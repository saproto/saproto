<template>
    <div class="container mx-auto px-4 py-6">
        <div class="flex flex-col lg:flex-row justify-end gap-8">
            <!-- Main Content -->
            <div class="w-full lg:w-6/12">
                <Card class="shadow-sm border">
                    <CardHeader>
                        <CardTitle class="text-sm font-normal text-muted-foreground">
                            You are here:
                            <Link :href="route('wiki::show', {path: null})" class="text-blue-600 hover:underline ml-1">wiki</Link>
                            <template v-if="page">
                <span
                    v-for="(part, index) in breadcrumbParts"
                    :key="index"
                    class="ml-2"
                >
                  >>
                  <Link
                      :href="route('wiki::show', {path: breadcrumbPath(index)})"
                      class="text-blue-600 hover:underline ml-1"
                  >
                    {{ part }}
                  </Link>
                </span>
                            </template>
                        </CardTitle>
                    </CardHeader>

                    <CardContent>
                        <h1 class="text-2xl font-bold mb-2">
                            {{ page?.title ?? 'S.A. Proto Wiki' }}
                        </h1>

                        <Separator v-if="page" class="my-4" />

                        <!-- Markdown -->
                        <div v-if="page" class="prose max-w-none" v-html="renderedMarkdown"></div>

                        <!-- Sub Pages -->
                        <div v-if="children.length" class="mt-6">
                            <h3 class="text-lg font-semibold mb-2">
                                {{ page ? 'Sub pages' : 'Sections within this Wiki' }}
                            </h3>
                            <ul class="space-y-2">
                                <li class="list-item" v-for="(child) in children" :key="child.full_path">
                                    <Link
                                        :href="route('wiki::show', {path: child.full_path})"
                                        class="text-blue-600 hover:underline"
                                    >
                                        <i class="fa-solid fa-link mr-1"></i> {{ child.title }}
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </CardContent>
                </Card>
            </div>

            <!-- Sticky Sidebar -->
            <div class="w-full lg:w-3/12">
                <div class="sticky top-4">
                    <Card>
                        <CardContent class="p-4">
                            <div v-if="children.length">
                                <h3 class="text-lg font-semibold mb-2">
                                    {{ page ? 'Sub pages' : 'Sections within this Wiki' }}
                                </h3>
                                <ul class="space-y-2">
                                    <li v-for="(child, index) in children" :key="child.full_path">
                                        <Link
                                            :href="route('wiki::show', {path:child.full_path})"
                                            class="text-blue-600 hover:underline"
                                        >
                                            <i class="fa-solid fa-link mr-1"></i> {{ child.title }}
                                        </Link>
                                    </li>
                                </ul>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    </div>
    <MdEditor @onUploadImg="onUploadImg" v-model="text" language="en-US" previewTheme="github" noKatex noMermaid noUploadImg />
</template>

<script setup>
import { computed, ref } from 'vue'
import { usePage, Link } from '@inertiajs/vue3'
import { marked } from 'marked'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card/index.js'
import {Separator} from '@/components/ui/separator/index.js';
import WikiLayout from '@/layouts/WikiLayout.vue'
defineOptions({
    layout: WikiLayout,
})

import { config, MdEditor } from 'md-editor-v3';
import 'md-editor-v3/lib/style.css';

import screenfull from 'screenfull';

import Cropper from 'cropperjs';
import 'cropperjs/dist/cropper.css';

import highlight from 'highlight.js';
import 'highlight.js/styles/atom-one-dark.css';

import * as prettier from 'prettier';
import parserMarkdown from 'prettier/plugins/markdown';

config({
    editorExtensions: {
        prettier: {
            prettierInstance: prettier,
            parserMarkdownInstance: parserMarkdown,
        },
        highlight: {
            instance: highlight,
        },
        screenfull: {
            instance: screenfull,
        },
        cropper: {
            instance: Cropper,
        },
    },
});

const { props } = usePage()
const page = computed(()=>props.page)
const children = computed(()=>props.children)
// Breadcrumb logic
const breadcrumbParts = computed(() => {
    return page.value?.full_path.split('/') ?? []
})

const text = ref('Hello Editor!');

const breadcrumbPath = (index) =>
    breadcrumbParts.value.slice(0, index + 1).join('/')
// Markdown rendering
const renderedMarkdown = computed(() =>
    page.value.content ? marked.parse(page.value.content) : ''
)
</script>
