<template>
    <button :class="['btn', size ? 'btn-' + size : '', type ? 'btn-' + type : '']" :disabled="disabled || loading">
        <sa-icon v-if="icon" :icon="(loading ? 'cog' : icon)" :spin="loading" />
        <slot />
    </button>
</template>

<script>
    export default {
        props: {
            type: {default: 'default'}, // default, primary, success, info, warning, danger
            size: {default: false}, // lg, sm, xs
            disabled: {default: false},
            loading: {default: false},
            icon: {default: false},
        }
    }
</script>
