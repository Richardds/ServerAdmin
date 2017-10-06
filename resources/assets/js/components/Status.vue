<template>
    <div :class="['alert', typeClass, 'alert-dismissible']" role="alert">
        <button @click="$emit('close')" type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="fa fa-times" aria-hidden="true"></i>
        </button>
        <slot></slot>
    </div>
</template>

<script>
    export default {
        props: {
            type: {default: 'warning'}
        },
        computed: {
            typeClass: function () {
                return 'alert-' + this.type;
            }
        }
    }
</script>
