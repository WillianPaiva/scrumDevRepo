
<template>
    <div class="well">
        <div v-for="item in membs">
            {{ item.name }}
        </div>
    </div>
</template>


<script>
    export default {

        props: ['pid','membs'],

    mounted() {
        this.$http.get('/api/members/'+this.pid).then(function (response) {
            this.membs = response.data;
        });
    },
    created() {
        this.$on('addnewmember', function(){
            console.log('fired');
        });
    },
    watch:{
        members: function(){
            console.log(this.members);
        }
    }
    }
</script>
