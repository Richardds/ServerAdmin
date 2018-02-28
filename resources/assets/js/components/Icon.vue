<template>
    <i :class="['fa', 'fa-' + icon, {'fa-spin' : spin}]" aria-hidden="true"></i>
</template>

<script>
    export default {
        props: {
            icon: {default: 'question'},
            spin: {default: false},
        }
    }
</script>
