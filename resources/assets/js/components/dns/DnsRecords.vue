<template>
    <table class="table table-striped table-controls table-dns-records">
        <thead>
        <tr>
            <th>Type</th>
            <th>Name</th>
            <th>Value</th>
            <th>TTL</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <sa-dns-record v-for="record in this.records"
                     :key="record.id"
                     :record="record"
                     @destroy-record="destroy(record.id)">
        </sa-dns-record>
        </tbody>
    </table>
</template>

<script>
    export default {
        props: ['zone'],
        data() {
            return {
                records: []
            };
        },
        mounted() {
            axios.get('/api/dns/records?zone=' + this.zone).then(response => {
                for (let record of response.data.data) {
                    this.records.push(record);
                }
            }).catch(error => {
                console.error(error);
            });
        },
        methods: {
            destroy(id) {
                this.records = _.remove(this.records, record => record.id !== id);
            }
        }
    }
</script>
