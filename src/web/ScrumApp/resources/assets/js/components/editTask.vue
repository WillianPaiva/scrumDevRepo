<template>
    <div class="container">
        <modal title="Edit Task"
               :show.sync="boolShow"
               :okText="'Edit'"
               :okClass="'btn btn-success'"
               :cancelClass="'btn btn-danger'"
               @ok="editTask"
               @cancel="cancel">


            <form class="form-horizontal" >
                <div class="form-group">
                    <label for="name"  class="col-md-4 control-label">Name</label>
                    <div class="col-md-6">
                        <input id="name" v-model="editTaskRequest.name" type="text" class="form-control" name="name" required />
                    </div>
                </div>
                <div class="form-group">
                    <label for="description"  class="col-md-4 control-label">description</label>
                    <div class="col-md-6">
                        <textarea id="description" v-model="editTaskRequest.description"
                                  type="text" class="form-control" name="description" required /></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="cost"  class="col-md-4 control-label">cost</label>
                    <div class="col-md-2">
                        <input id="cost" v-model="editTaskRequest.cost"
                               type="number"  class="form-control" name="cost" min="1" step="0.25" required/>
                    </div>
                    <label for="priority"  class="col-md-2 control-label">priority</label>
                    <div class="col-md-2">
                        <input id="priority" v-model="editTaskRequest.priority"
                               type="number" class="form-control" name="priority" min="1" required />
                    </div>
                </div>
                </div>
            </form>
        </modal>
    </div>
</template>

<script>
 export default{
     data(){
         return{
             editTaskRequest:{
                 id: '',
                 name: '',
                 description: '',
                 status: '',
                 commit: '',
                 cost: '1',
                 priority: '1',
                 date_begin: '',
                 date_estimated: '',
                 date_finished: '',
                 user_story_id: '',
                }
         }
     },
     props:['id','boolShow'],
 watch:{
      boolShow:function(){
           this.update();
      }
},
     methods:{
          update: function (){
               console.log('/api/taskEdit/'+this.id);
               this.$http.get('/api/taskEdit/'+this.id).then(function(response){
                    this.editTaskRequest=response.data;
               });
            console.log('hello --->'+this.editTaskRequest.id);

          },
         editTask: function(){
             this.editTaskRequest.user_story_id = this.id;
             this.$http.post('/api/task/edit', this.editTaskRequest);
             this.editTaskRequest = {
                 id: '',
                 name: '',
                 description: '',
                 status: '',
                 commit: '',
                 cost: '',
                 priority: '',
                 date_begin: '',
                 date_estimated: '',
                 date_finished: '',
                 user_story_id: '',
             }
             this.boolShow = false;
             this.$emit('ok');
         },
         cancel: function(){
             this.boolShow = false;
             this.$emit('cancel');
         },
     }

 }
</script>
