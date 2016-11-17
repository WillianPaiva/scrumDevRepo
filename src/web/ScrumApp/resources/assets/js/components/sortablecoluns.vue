<template>
    <div>
        <ul class="list-inline">
            <li class="DocumentItem" v-for="(col, index) in colunms" :index="index">
                <div class="panel panel-warning">
                    <div class="panel-heading clearfix">
                        {{col.name}}
                    </div>
                    <div class="panel-body">
                        <div class="well">
                            <sortabletasks :sprintid="sprintid" :status="col.name" ></sortabletasks>
                        </div>
                    </div>
                </div>
            </li>
            <li><button class="btn btn-success" v-on:click="modalShow=true">
                <i class="fa fa-plus"></i>
            </button></li>
        </ul>
        <div class="container">
            <modal title="new colunm"
                   :show.sync="modalShow"
                   :okText="'Create'"
                   :okClass="'btn btn-success'"
                   :cancelClass="'btn btn-danger'"
                   @ok="addColunm"
                   @cancel="modalShow=false">
                <form class="form-horizontal" >
                    <div class="form-group">
                        <label for="name"  class="col-md-4 control-label">Name</label>
                        <div class="col-md-6">
                            <input id="name"
                                   v-model="colname"
                                   type="text"
                                   class="form-control"
                                   name="name"
                                   required />
                        </div>
                    </div>
                </form>
            </modal>
        </div>
    </div>
</template>
<script>
 import Sortable from 'sortablejs'
 export default{
     data(){
         return {
             colunms:[],
             modalShow: false,
             colname:''
         }
     },
     props:['sprintid'],
     mounted(){
         this.sortable();
         this.fetch();
     },
     methods:{
         fetch: function(){
             this.$http.get('/api/layout/'+this.sprintid).then(function(response){
                 this.colunms = response.data;
             });


         },
         sortable: function () {
             var that = this;
             Sortable.create(this.$el.firstChild, {
                 draggable: 'li',
                 animation: 100,
                 onUpdate: function(e) {
                     that.updateColunms(e.oldIndex,e.newIndex);
                 }
             });
         },

         updateColunms: function(oldIndex, newIndex){
             console.log( "Moving " + oldIndex + " to " + newIndex);
         }
     },

 }
</script>
<style>
 .DocumentList
 {
     /* overflow-x:hidden; */
     /* overflow-y:hidden; */
     height:100%;
     width:100%;
     padding: 0 15px;
 }

 .DocumentItem
 {
     padding:0;
     height:100%;
     width:300px;
     vertical-align: top;
 }

 .list-inline {
     white-space:nowrap;
 }

</style>
