<template>
    <button :class="['btn', size ? 'btn-' + size : '', type ? 'btn-' + type : '']" :disabled="loading">
        <i v-if="icon" :class="['fa', 'fa-' + (loading ? 'cog' : icon), {'fa-spin' : loading}]" aria-hidden="true"></i>
        <slot></slot>
    </button>
</template>

<script>
    export default {
        props: {
            type: {default: 'default'}, // default, primary, success, info, warning, danger
            size: {default: false}, // lg, sm, xs
            loading: {default: false},
            icon: {default: false}
        }
    }
</script>
