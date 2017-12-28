<template>
    <div :class="['modal', 'fade', {'in' : visible}]" role="dialog" v-if="visible">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button @click="$emit('close')" type="button" class="close" data-dismiss="modal">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>
                    <h4 class="modal-title">{{ title }}</h4>
                </div>
                <div class="modal-body">
                    <slot></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            'visible': {default: true},
            'title': {default: 'Title'}
        }
    }
</script>
