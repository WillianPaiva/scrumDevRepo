<template>
    <div class="container">
            <div class="row">
                <div class="col-md-12 col-md-offset-0">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <label class="label label-warning" style="margin-right: 7px;">
                                US#{{nb}}
                            </label>

                            <label class="label label-success" style="margin-right: 7px;">
                                effort
                                <span class="badge">{{ us.effort }}</span> 
                            </label>

                            <label class="label label-info" style="margin-right: 7px;">
                                priority
                                <span class="badge">{{ us.priority }}</span> 
                            </label>

                        </div>
                        <div class="panel-body">
                            <label class="col-md-4 control-label" for="">Description</label>
                        </br>
                            <div class="well">{{us.description}}</div>

                            <label class="col-md-4 control-label" for="">Tasks</label>
                        </br>
                        <div class="well" v-if="isEmpty()"><h3>no tasks</h3></div>
                        </div>

                    </div>
                </div>
            </div>
    </div>
</template>
<script>
 export default{
     data(){
         return{
             tasks:[],
             us:{
             description: '',
             status: '',
             commit: '',
             date_begin: '',
             date_estimated: '',
             date_finished: '',
             effort: '1',
             priority: '0',
             project_id: '',
             sprint_id: ''
             }
         }
     },
     props:['id','nb'],
     mounted(){
         this.getUS();
         },
     watch:{
         boolShow:function(){
             this.getUS();
         }
     },

     methods:{
         getUS: function(){
             this.$http.get('/api/us/'+this.id).then(function(response){
                 this.us = response.data;
             });
         },
         isEmpty: function(){
             return !(this.tasks.length > 0)
         }
     }

 }
</script>
