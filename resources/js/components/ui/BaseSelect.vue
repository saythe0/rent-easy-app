<template>
    <label class="block text-sm font-medium text-ink/80" :for="selectId">
        {{ label }}
    </label>
    <div class="mt-2">
        <select
            :id="selectId"
            class="w-full rounded-2xl border border-ink/15 bg-white px-4 py-3 text-sm shadow-soft outline-none transition focus:border-ink/40"
            :value="modelValue"
            v-bind="$attrs"
            @change="$emit('update:modelValue', $event.target.value)"
        >
            <option v-for="option in options" :key="option.value" :value="option.value">
                {{ option.label }}
            </option>
        </select>
    </div>
    <FormError v-if="error" :message="error" class="mt-2" />
</template>

<script setup>
import { computed } from 'vue'
import FormError from '@/components/ui/FormError.vue'

const props = defineProps({
    label: { type: String, default: '' },
    modelValue: { type: [String, Number], default: '' },
    options: { type: Array, default: () => [] },
    id: { type: String, default: '' },
    error: { type: String, default: '' },
})

defineEmits(['update:modelValue'])

defineOptions({
    inheritAttrs: false,
})

const selectId = computed(() => props.id || `select-${Math.random().toString(36).slice(2, 9)}`)
</script>
