<template>
    <div>
        <label for="user" class="col-md-4 control-label">User</label>
        <div class="col-md-6">
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-spinner fa-spin" v-if="loading"></i>
                <template v-else>
                    <i class="fa fa-search" v-show="isEmpty"></i>
                    <i class="fa fa-times" v-show="isDirty" @click="reset"></i>
                </template>
            </span>
            <input type="text"
                   class="form-control"
                   name="user"
                   placeholder="Search user"
                   autocomplete="on"
                   v-model="query"
                   @keydown.down="down"
                   @keydown.up="up"
                   @keydown.enter="hit"
                   @keydown.esc="reset"
                   @blur="reset"
                   @input="update"/>

        </div><!-- /input-group -->
            <ul v-show="hasItems" >
                <li v-for="(item,index) in items" :class="activeClass(index)"
                    @mousedown="hit" @mousemove="setActive(index)">
                    <span class="name" v-text="item.name"></span>
                    <span class="screen-name" v-text="item.id"></span>
                </li>
            </ul>
    </div>
    </div>
</template>

<script>
import VueTypeahead from 'vue-typeahead'

export default {
  extends: VueTypeahead, // vue@1.0.22+
  // mixins: [VueTypeahead], // vue@1.0.21-
     props: ['pid'],
  data () {
    return {
      // The source url
      // (required)
      src: '/api/userlist',

      // The data that would be sent by request
      // (optional)
      data: {},

      // Limit the number of items which is shown at the list
      // (optional)
      limit: 5,

      // The minimum character length needed before triggering
      // (optional)
      minChars: 3,

      // Highlight the first item in the list
      // (optional)
      selectFirst: false,

      // Override the default value (`q`) of query parameter name
      // Use a falsy value for RESTful query
      // (optional)
      queryParamName: 'q'
    }
  },

  methods: {
    // The callback function which is triggered when the user hits on an item
    // (required)
    onHit (item) {
        this.$http.post('/api/adduser/'+item.id+'/'+this.pid);
    },

    // The callback function which is triggered when the response data are received
    // (optional)
    prepareResponseData (data) {
      // data = ...
      return data
    }
  }
}
</script>
