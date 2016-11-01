
<template>  
    <div class="well">
    </br>
        <div v-for="item in members">
            {{ item.name }}
        </div>
    </div>
</template>




<script>
    export default {
        data: function() {

            return { members: [] };
        },
        props: ['pid'],
        mounted() {
                this.$http.get('/api/members/'+this.pid).then(function (response) {
                    this.members = response.data;
                });
        },
    }
</script>
