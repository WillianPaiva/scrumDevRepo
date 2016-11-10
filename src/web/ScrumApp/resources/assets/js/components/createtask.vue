<template>
    <div class="container">
        <modal title="Create New Task"
               :show.sync="showAddTask"
               :okText="'Create'"
               :okClass="'btn btn-success'"
               :cancelClass="'btn btn-danger'"
               @ok="createTask"
               @cancel="cancel">


            <form class="form-horizontal" >
                <div class="form-group">
                    <label for="name"  class="col-md-4 control-label">Name</label>
                    <div class="col-md-6">
                        <input id="name" v-model="taskRequest.name" type="text" class="form-control" name="name" required />
                    </div>
                </div>
                <div class="form-group">
                    <label for="name"  class="col-md-4 control-label">description</label>
                    <div class="col-md-6">
                        <textarea id="name" v-model="taskRequest.description"
                                  type="text" class="form-control" name="name" required /></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name"  class="col-md-4 control-label">cost</label>
                    <div class="col-md-2">
                        <input id="name" v-model="taskRequest.cost"
                               type="number" class="form-control" name="name" min="1" required />
                    </div>
                    <label for="name"  class="col-md-2 control-label">priority</label>
                    <div class="col-md-2">
                        <input id="name" v-model="taskRequest.priority"
                               type="number" class="form-control" name="name" min="1" required />
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
             task:[],
             taskRequest:{
                 id: '',
                 name: '',
                 description: '',
                 status: '',
                 commit: '',
                 cost: '0',
                 priority: '0',
                 date_begin: '',
                 date_estimated: '',
                 date_finished: '',
                 user_story_id: ''
                }
         }
     },
     props:['id', 'showAddTask'],

     methods:{
         isEmpty: function(){
         },
         createTask: function(){
             this.showAddTask = false;
             this.$emit('ok');
         },
         cancel: function(){
             this.showAddTask = false;
             this.$emit('cancel');
         },
     }

 }
</script>
