<template>
    <div>
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-9">
                    <div class="panel panel-default">
                        <div class="panel-heading clearfix">
                            <div class="container-fluid panel-container">
                                <div class="col-xs-3 text-left">
                                    <h4 class="panel-title abc">
                                        {{ project.name }}
                                    </h4>
                                </div>


                             <div class="col-xs-6 text-center ">
                                 <select  v-model="order" class="abc">
                                     <option value="created_at">created</option>
                                     <option value="effort">effort</option>
                                     <option value="priority">priority</option>
                                 </select>
                             </div>

                             <div class="col-xs-3 text-right">
                                 <button class="btn btn-success pull-right" v-on:click="showAddUs = true">
                                     <i class="fa fa-plus"></i>
                                 </button>
                             </div>

                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="well">
                                <div v-if="isEmpty()">
                                    <h1>backlog is empty</h1>
                                </div>
                                <ul class="list-group">
                                    <li class="list-group-item clearfix" style="" v-for="item in userstory">
                                        <p style="top:15%;" class="truncate">
                                            {{ item.description }}
                                        </p>
                                        <div>
                                            <label class="label label-success">
                                                Effort
                                                <span class="badge">{{ item.effort }}</span> 
                                            </label>
                                            <label class="label label-info">
                                                Priority
                                                <span class="badge">{{ item.priority }}</span> 
                                            </label>
                                        <button class="btn btn-danger pull-right" v-on:click="deleteUs(item)"><span class="fa fa-trash"></span></button>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title pull-left" style="padding-top: 7.5px;">
                                Sprints 
                            </h4>
                            <button class="btn btn-success pull-right" >
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>

                        <div class="panel-body">
                            <div class="well">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <createus v-bind:boolShow="showAddUs" :id="id" @close="close()"></createus>



    </div>
</template>
<script>
 export default{
     data(){
         return{
             order: 'created_at',
             project:{},
             userstory:[],
             showAddUs: false,
             userStoryRequest:{
                 id: '',
                 description: '',
                 status: '',
                 commit: '',
                 date_begin: '',
                 date_estimated: '',
                 date_finished: '',
                 effort: '0',
                 priority: '0',
                 project_id: '',
                 sprint_id: ''
             }
         }
     },
     watch: {
         order: function(){
             this.fetch();
         }
     },
     props:['id'],
     mounted(){
         this.fetch();
     },
     methods:{
         fetch: function(){
             this.$http.get('/api/backlog/'+this.id+'/'+this.order).then(function(response){
                 this.userstory = response.data;
             });
             this.$http.get('/api/project/'+this.id).then(function(response){
                 this.project = response.data;
             });
         },
         isEmpty: function(){
             return !(this.userstory.length > 0);
         },
         deleteUs: function(item){
             this.$http.post('/api/us/delete/'+item.id);
             this.fetch();
         },
         close: function(){
             this.showAddUs = false;
             this.fetch();
             }
     }

     }

</script>
<style>
.truncate {
  width: 100%;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.panel-container {
    padding-right: 0 !important;
    padding-left: 0 !important;
    height:35px;
}
.abc{
    height:35px;
      display:table-cell !important;
      vertical-align:middle;
}
 </style>
