<template>
    <div>
      <ul class="list-group">
                <li class="list-group-item clearfix"
                    v-for="task in tasks" :taskid="task.id">{{task.name}}
                    <p style="top:15%;" class="truncate">
                    <div><label class="label label-warning" style="margin-right: 7px;">
                        US#{{getUsIndex(task.user_story_id)}}
                    </label>
                  </div>
                  <div>
                    <label class="label label-info" style="margin-right: 7px;">
                        priority
                        <span class="badge">{{ task.priority }}</span>
                    </label>
                    <label class="label label-success" style="margin-right: 7px;">
                        effort
                        <span class="badge">{{ task.effort }}</span>
                    </label>
                  </div>
                  </p>
                    </li>
                    </ul>

    </div>
</template>
<script>
import Sortable from 'sortablejs'
export default{
    props:['sprintid','status','ids'],
    data(){
        return{
            tasks:[],
            boolCommitShow:false,
        }
    },
    mounted(){
        this.fetch();
        this.sortable();
    },
    watch:{
        boolCommitShow: function(){
            console.log('bool ->'+this.boolCommitShow);
        }
    },
    methods:{
      fetch: function(){
          this.$http.get('/api/get_tasks/'+this.sprintid+'/'+this.status).then(function(response){
              this.tasks = response.data;
          });
      },
        getUsIndex: function (item) {
            return this.ids.indexOf(parseInt(item));
        },
        sortable: function () {
            var that = this;
            Sortable.create(this.$el.firstChild, {
                draggable: 'li',
                group: "tasks",
                animation: 100,
                sort: false,
                onAdd: function (evt) {
                    /* var itemEl = evt.item;*/
                    var taskid = this.el.firstChild.getAttribute("taskid");
                    that.$http.post('/api/updatetask/'+taskid+'/'+that.status).then(function (response){
                        if (this.status=='DONE'){
                            console.log('this -->'+this.status);
                            console.log('that-->'+that.status);
                            this.boolTrue();
                        }

                    });
                    that.$http.post('/api/updateus/'+that.sprintid);
                        //that.boolCommitShow=false;
                    /* evt.from;*/
                    // + indexes from onEnd
                },
                onUpdate:function(e){


                },
                onRemove: function (/**Event*/evt) {
                    console.log("this is the removal-->"+that.status);
                },
            });
        },
        boolTrue : function (){
        this.boolCommitShow=true;
        console.log('-boolTrue');
        },
        addCommit: function (){
            console.log('addCommit');
        this.boolCommitShow=false;
        },
        isEmpty: function(){
            return !(this.tasks.lenght > 0);
        },
        cancel:function (){
            console.log('cancel called');
            this.boolCommitShow=false;
        },
        getUsId: function(item){
            return this.array[this.ids.indexOf(item)];
        },
    }
}
</script>
<style>
.list-group{
    min-height: 50px;
}
</style>
