<template>
    <tr>
        <td class="zone-name">{{ zone.name }}</td>
        <td class="zone-records-count">

        </td>
        <td class="fit">
            <a href="/zone/1" class="btn btn-sm btn-default">
                <i class="fa fa-pencil" aria-hidden="true"></i>
            </a>
            <button class="btn btn-sm btn-default">
                <i :class="['fa', enabledStatusClass]" aria-hidden="true"></i>
            </button>
            <button @click="deleteZone" class="btn btn-sm btn-danger">
                <i class="fa fa-trash" aria-hidden="true"></i>
            </button>
        </td>
    </tr>
</template>

<script>
    export default {
        props: ['zone'],
        methods: {
            deleteZone() {
                axios.delete('/ajax/dns/zones/' + this.zone.id).then(response => {
                    this.$emit('onZoneDestroy', this.zone);
                    console.log('Success!');
                    // call bind config reload
                }).catch(error => {
                    console.error(error);
                });
            }
        },
        computed: {
            enabledStatusClass() {
                return this.zone.enabled ? 'fa-toggle-on' : 'fa-toggle-off';
            }
        }
    }
</script>
