<template>
    <div class="container">
        <modal title="Create New Project"
               :show.sync="boolShow"
               :okText="'Create'"
               :okClass="'btn btn-success'"
               :cancelClass="'btn btn-danger'"
               @ok="ok"
               @cancel="cancel">
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
                            <label class="col-md-4 control-label" for=""></label>
                            <div class="well">{{us.description}}</div>
                        </div>

                    </div>
                </div>
            </div>
        </modal>
    </div>
</template>
<script>
 export default{
     data(){
         return{
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
     props:['id','nb', 'boolShow'],
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
         ok: function(){
             this.boolShow = false;
             this.$emit('close');
         },
         cancel: function(){
             this.boolShow = false;
             this.$emit('close');
         },
     }

 }
</script>
