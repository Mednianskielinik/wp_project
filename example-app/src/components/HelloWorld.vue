<template>
    <div class="hello">
        <md-list :md-expand-single="true">
            <md-list-item md-expand>
                <md-icon>work</md-icon>
                <span class="md-list-item-text">Default API</span>
                <md-list slot="md-expand">
                    <router-link to="/default">
                    <md-list-item class="md-inset">/wp-json/wp/v2/posts</md-list-item>
                    </router-link>
                    <md-list-item class="md-inset">/wp-json/wp/v2/revisions</md-list-item>
                    <md-list-item class="md-inset">/wp-json/wp/v2/categories</md-list-item>
                    <md-list-item class="md-inset">/wp-json/wp/v2/tags</md-list-item>
                    <md-list-item class="md-inset">/wp-json/wp/v2/pages</md-list-item>
                    <md-list-item class="md-inset">/wp-json/wp/v2/comments</md-list-item>
                    <md-list-item class="md-inset">/wp-json/wp/v2/taxonomies</md-list-item>
                    <md-list-item class="md-inset">/wp-json/wp/v2/media</md-list-item>
                    <md-list-item class="md-inset">/wp-json/wp/v2/users</md-list-item>
                    <md-list-item class="md-inset">/wp-json/wp/v2/types</md-list-item>
                    <md-list-item class="md-inset">/wp-json/wp/v2/statuses</md-list-item>
                    <md-list-item class="md-inset">/wp-json/wp/v2/settings</md-list-item>
                </md-list>
            </md-list-item>
            <md-list-item md-expand>
                <md-icon>stars</md-icon>
                <span class="md-list-item-text">Custom API</span>
                <md-list slot="md-expand">
                    <router-link to="/custom">
                    <md-list-item class="md-inset">/wp-json/my-route/v1/search</md-list-item>
                    <md-list-item class="md-inset">/wp-json/my-route/v1/create</md-list-item>
                    <md-list-item class="md-inset">/wp-json/my-route/v1/update</md-list-item>
                    <md-list-item class="md-inset">/wp-json/my-route/v1/delete</md-list-item>
                    </router-link>
                </md-list>
            </md-list-item>
        </md-list>
    </div>
</template>

<script>
    export default {
        name: 'HelloWorld',
        props: {
            msg: String
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
