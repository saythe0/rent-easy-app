<template>
    <label class="block text-sm font-medium text-ink/80" :for="textareaId">
        {{ label }}
    </label>
    <div class="mt-2">
        <textarea
            :id="textareaId"
            class="min-h-[120px] w-full rounded-2xl border border-ink/15 bg-white px-4 py-3 text-sm shadow-soft outline-none transition focus:border-ink/40"
            :placeholder="placeholder"
            :value="modelValue"
            v-bind="$attrs"
            @input="$emit('update:modelValue', $event.target.value)"
        />
    </div>
    <FormError v-if="error" :message="error" class="mt-2" />
</template>

<script setup>
import { computed } from 'vue'
import FormError from '@/components/ui/FormError.vue'

const props = defineProps({
    label: { type: String, default: '' },
    modelValue: { type: [String, Number], default: '' },
    placeholder: { type: String, default: '' },
    id: { type: String, default: '' },
    error: { type: String, default: '' },
})

defineEmits(['update:modelValue'])

defineOptions({
    inheritAttrs: false,
})

const textareaId = computed(() => props.id || `textarea-${Math.random().toString(36).slice(2, 9)}`)
</script>
