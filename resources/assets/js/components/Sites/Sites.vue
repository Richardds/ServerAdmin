<template>
    <ul><site v-for="site in sites" :key="site.name">{{ site.name }}</site></ul>
</template>

<script>
    export default {
        mounted() {
            //
        },
        data() {
            return {
                sites: [
                    { name: 'serveradmin.local', ip: '192.168.100.200' },
                    { name: 'serveradmin1.local', ip: '192.168.100.201' },
                    { name: 'serveradmin2.local', ip: '192.168.100.202' }
                ]
            }
        }
    }
</script>
