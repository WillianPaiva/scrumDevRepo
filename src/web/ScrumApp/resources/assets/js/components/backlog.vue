<template>
    <div>
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-9">
                    <div class="panel panel-default">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title pull-left" style="padding-top: 7.5px;">
                                {{ project.name }}
                            </h4>
                            <button class="btn btn-success pull-right" v-on:click="showAddUs = true">
                                <i class="fa fa-plus"></i>
                            </button>
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





        <div class="container">
            <modal title="Create New Project"
                   :show.sync="showAddUs"
                   :okText="'Create'"
                   :okClass="'btn btn-success'"
                   :cancelClass="'btn btn-danger'"
                   @ok="createUs"
                   @cancel="cancel">


                <form class="form-horizontal" >
                    <div class="form-group">
                        <label for="name"  class="col-md-4 control-label">description</label>
                        <div class="col-md-6">
                            <textarea id="name" v-model="userStoryRequest.description"
                                      type="text" class="form-control" name="name" required /></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name"  class="col-md-4 control-label">effort</label>
                        <div class="col-md-2">
                            <select class="form-control" v-model="userStoryRequest.effort" required>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="5">5</option>
                                <option value="8">8</option>
                                <option value="13">13</option>
                                <option value="21">21</option>
                                <option value="34">34</option>
                                <option value="55">55</option>
                                <option value="89">89</option>
                            </select>
                        </div>
                        <label for="name"  class="col-md-2 control-label">priority</label>
                        <div class="col-md-2">
                            <input id="name" v-model="userStoryRequest.priority"
                                   type="number" class="form-control" name="name" required />
                        </div>
                    </div>
                </form>
            </modal>
        </div>
    </div>
</template>
<script>
 export default{
     data(){
         return{
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
     props:['id'],
     mounted(){
         this.fetch();
     },
     methods:{
         fetch: function(){
             this.$http.get('/api/backlog/'+this.id).then(function(response){
                 this.userstory = response.data;
             });
             this.$http.get('/api/project/'+this.id).then(function(response){
                 this.project = response.data;
             });
         },
         isEmpty: function(){
             return !(this.userstory.length > 0);
         },
         createUs: function(){
             this.userStoryRequest.project_id = this.id;
             this.$http.post('/api/us/add', this.userStoryRequest);
             this.userStoryRequest = {
                 id: '',
                 description: '',
                 status: '',
                 commit: '',
                 date_begin: '',
                 date_estimated: '',
                 date_finished: '',
                 effort: '',
                 priority: '',
                 project_id: '',
                 sprint_id: ''
             }
             this.fetch();
             this.showAddUs = false;
         },
         cancel: function(){
             this.showAddUs = false;
         },
         deleteUs: function(item){
             this.$http.post('/api/us/delete/'+item.id);
             this.fetch();
         },


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
 </style>
