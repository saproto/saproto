<script setup lang="ts">
import { ref, watch } from "vue";
import type { Ref } from "vue";

defineOptions({
    inheritAttrs: false
});

interface Result {
    id: number;
    name: string;
}

const props = withDefaults(
    defineProps<{
        name?: string;
        id?: string;
        multiSelect?: boolean;
        unique?: boolean;
        disabled?: boolean;
        required?: boolean;
        value?: Result | Array<Result>;
        modelValue?: number | Array<number> | null;
    }>(),
    {
        name: undefined,
        id: undefined,
        value: undefined,
        modelValue: undefined
    }
);

const inputField: Ref<HTMLElement | undefined> = ref();
const search = ref("");
const results: Ref<Array<Result>> = ref([]);
const selected: Ref<Array<Result>> = ref(props.value ? (props.multiSelect ? props.value : [props.value]) : []);

const onChange = async (e: Event) => {
    if (e.target?.value.length < 3) {
        results.value = [{ id: 0, name: "Type at least 3 characters." }];
        return;
    }
    const url = new URL("/api/search/committee", window.location.origin);
    url.search = new URLSearchParams({ q: search.value }).toString();
    results.value = await fetch(url).then((res) => res.json());
};

const onSelect = (result: Result) => {
    if (!props.multiSelect) selected.value.pop();
    selected.value.push(result);
    search.value = "";
    results.value = [];
    inputField.value?.focus();
};

const removeSelected = () => {
    if (search.value.length > 0) return;
    selected.value.pop();
};

watch(
    selected,
    (val, newVal) => {
        if (props.multiSelect) {
            emit(
                "update:modelValue",
                newVal.map((sel) => sel.id)
            );
        } else {
            emit("update:modelValue", newVal[0]?.id);
        }
    },
    { deep: true }
);

const emit = defineEmits(["update:modelValue"]);
</script>

<template>
    <div class="relative">
        <div
            class="z-10 relative peer shadow rounded flex space-x-3 flex-wrap items-center m-0 p-0 px-3 border border-gray-500 ring-blue-600 focus-within:ring-1 focus-within:outline-none focus-within:border-blue-600 w-full text-front bg-back disabled:bg-back-light"
        >
            <div v-for="sel in selected" :key="sel.id" class="bg-primary text-front-dark rounded text-xs p-1 m-1">
                {{ sel.name }}
            </div>
            <div class="flex-grow peer">
                <input
                    :id="id ?? name"
                    ref="inputField"
                    v-model="search"
                    type="text"
                    class="focus:ring-0 leading-tight w-full text-front px-0 py-2 rounded border-none"
                    :disabled="disabled"
                    :required="required"
                    @input="onChange"
                    @keydown.backspace="removeSelected"
                />
            </div>
        </div>
        <ul
            class="z-0 hidden peer-focus-within:block hover:block absolute bg-back w-full shadow rounded-b pt-2 -mt-2 border border-gray-500"
        >
            <li v-for="result in results" :key="result.id" class="hover:bg-back-light" @click="() => onSelect(result)">
                {{ result.name }}
            </li>
            <li v-if="results.length == 0">No results</li>
        </ul>
    </div>
</template>

<style scoped></style>
