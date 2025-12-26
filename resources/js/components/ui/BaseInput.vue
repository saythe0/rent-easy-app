<template>
    <label class="block text-sm font-medium text-ink/80" :for="inputId">
        {{ label }}
    </label>
    <div class="mt-2">
        <input
            :id="inputId"
            class="w-full rounded-2xl border border-ink/15 bg-white px-4 py-3 text-sm shadow-soft outline-none transition focus:border-ink/40"
            :type="type"
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
    type: { type: String, default: 'text' },
    placeholder: { type: String, default: '' },
    id: { type: String, default: '' },
    error: { type: String, default: '' },
})

defineEmits(['update:modelValue'])

defineOptions({
    inheritAttrs: false,
})

const inputId = computed(() => props.id || `input-${Math.random().toString(36).slice(2, 9)}`)
</script>
