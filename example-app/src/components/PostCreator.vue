<template>
    <div>
        <div style="right: 50vw; top:50vh;position: absolute; z-index: 999">
            <md-progress-spinner :md-diameter="100" :md-stroke="10" md-mode="indeterminate"
                                 v-if="deletion"></md-progress-spinner>
        </div>
        <md-card md-with-hover>
            <md-card-content>
                <md-table v-model="posts" md-card @md-selected="onSelect">
                    <md-table-toolbar>
                        <h1 class="md-title">Select post to update</h1>
                        <!--<md-button class="md-fab md-mini md-primary" @click="createDialog = true">-->
                            <!--<md-icon>add</md-icon>-->
                        <!--</md-button>-->
                    </md-table-toolbar>

                    <md-table-row slot="md-table-row" slot-scope="{ item }" :class="'md-primary'"
                                  md-selectable="single">
                        <md-table-cell md-label="Title" md-sort-by="post_title">{{ item.title }}</md-table-cell>
                        <md-table-cell md-label="Content" md-sort-by="post_content">{{ item.content }}
                        </md-table-cell>
                        <md-table-cell md-label="Date" md-sort-by="gender">{{ item.date }}</md-table-cell>
                        <!--<md-table-cell md-label="Deleting">-->
                            <!--<md-button class="md-fab md-mini" @click="deletePost({item})">-->
                                <!--<md-icon>delete</md-icon>-->
                            <!--</md-button>-->
                        <!--</md-table-cell>-->
                    </md-table-row>
                </md-table>
            </md-card-content>
        </md-card>

        <!--<md-dialog :md-active.sync="active">-->

            <!--<md-dialog-title>Edit or delete</md-dialog-title>-->
            <!--<md-ripple>-->
                <!--<md-dialog-content>-->
                    <!--<div class="md-layout md-gutter">-->
                        <!--<div class="md-layout-item md-small-size-100">-->
                            <!--<md-field :class="getValidationClass('title')">-->
                                <!--<label for="first-name">Title</label>-->
                                <!--<md-input name="first-name" id="first-name" autocomplete="given-name"-->
                                          <!--v-model="form.title"-->
                                          <!--:disabled="sending"/>-->
                                <!--<span class="md-error" v-if="!$v.form.title.required">The Title is required</span>-->
                                <!--<span class="md-error" v-else-if="!$v.form.title.minlength">Invalid title</span>-->
                            <!--</md-field>-->
                        <!--</div>-->
                        <!--<div class="md-layout-item md-small-size-100">-->
                            <!--<md-field :class="getValidationClass('content')">-->
                                <!--<label for="last-name">Content</label>-->
                                <!--<md-input name="last-name" id="last-name" autocomplete="family-name"-->
                                          <!--v-model="form.content"-->
                                          <!--:disabled="sending"/>-->
                                <!--<span class="md-error" v-if="!$v.form.content.required">The content is required</span>-->
                                <!--<span class="md-error" v-else-if="!$v.form.content.minlength">Invalid content</span>-->
                            <!--</md-field>-->
                        <!--</div>-->
                    <!--</div>-->
                <!--</md-dialog-content>-->
                <!--<md-progress-bar md-mode="indeterminate" v-if="sending"/>-->

                <!--<md-dialog-actions>-->
                    <!--<md-button class="md-raised md-accent" @click="closeUpdateDialog">Cancel</md-button>-->
                    <!--<md-button class="md-raised md-primary" @click="validatePost">Save</md-button>-->
                <!--</md-dialog-actions>-->
            <!--</md-ripple>-->
        <!--</md-dialog>-->
        <md-dialog :md-active.sync="createDialog">

            <md-dialog-title>Create post</md-dialog-title>
            <md-ripple>
                <md-dialog-content>
                    <form novalidate @submit.prevent="validatePost">


                        <div class="md-layout md-gutter">
                            <div class="md-layout-item md-small-size-100">
                                <md-field :class="getValidationClass('title')">
                                    <label for="first-name">Title</label>
                                    <md-input name="first-name" autocomplete="given-name"
                                              v-model="form.title" :disabled="sending"/>
                                    <span class="md-error" v-if="!$v.form.title.required">The Title is required</span>
                                    <span class="md-error" v-else-if="!$v.form.title.minlength">Invalid title</span>
                                </md-field>
                            </div>

                            <div class="md-layout-item md-small-size-100">
                                <md-field :class="getValidationClass('content')">
                                    <label for="last-name">Content</label>
                                    <md-input name="last-name" autocomplete="family-name"
                                              v-model="form.content" :disabled="sending"/>
                                    <span class="md-error"
                                          v-if="!$v.form.content.required">The content is required</span>
                                    <span class="md-error" v-else-if="!$v.form.content.minlength">Invalid content</span>
                                </md-field>
                            </div>
                        </div>

                        <md-progress-bar md-mode="indeterminate" v-if="sending"/>

                        <md-dialog-actions>
                            <md-button class="md-raised md-accent" @click="closeAdditionDialog">Cancel</md-button>
                            <md-button class="md-raised md-primary" type="submit">Save</md-button>
                        </md-dialog-actions>
                    </form>
                </md-dialog-content>

            </md-ripple>
        </md-dialog>
        <md-snackbar :md-active.sync="postSaved">The post was saved with success!</md-snackbar>
        <md-snackbar :md-active.sync="postNotSaved">The post was not saved!</md-snackbar>
        <md-snackbar :md-active.sync="postDeleted">Post deleted!</md-snackbar>
    </div>
</template>

<script>
    import {validationMixin} from 'vuelidate'
    import {
        required,
        minLength,
    } from 'vuelidate/lib/validators'
    import axios from 'axios'
    axios.defaults.headers.common['Authorization'] = 'Basic Venera:Ilovelexa2016';
    const config = {
        headers: {
            Authorization: 'Basic Venera:20venerA1997',
        }
    }
    export default {
        name: "PostCreator",
        mixins: [validationMixin],
        data: () => ({
            deletion: false,
            postDeleted: false,
            selected: null,
            createDialog: false,
            postSaved: null,
            postNotSaved: null,
            posts: [],
            active: false,
            form: {
                title: null,
                content: null,

            },
            sending: false,
            lastPost: null,
        }),
        validations: {
            form: {
                title: {
                    required,
                    minLength: minLength(3)
                },
                content: {
                    required,
                    minLength: minLength(3)
                }
            }
        },
        beforeCreate() {
            axios
                .get('http://localhost:8888/wordpress/wp-json/wp/v2/posts')
                .then((response) => {
                    this.posts = response.data.map(item => {
                        return {
                            title: item.title.rendered,
                            content: item.content.rendered.replace('<p>', '').replace('</p>', ''),
                            date: item.date.replace('T',' '),
                            id: item.id
                        }
                    })
                });
        },
        methods: {
            search() {
                axios
                    .get('http://localhost:8888/wordpress/wp-json/wp/v2/posts')
                    .then((response) => {
                        this.posts = response.data.map(item => {
                            return {
                                title: item.title.rendered,
                                content: item.content.rendered.replace('<p>', '').replace('</p>', ''),
                                date: item.date.replace('T',' ')
                            }
                        })
                    });
            },
            closeUpdateDialog() {
                this.active = false;
                this.clearForm();
            },
            patchForm() {
                if (this.selected) {
                    this.form.title = this.selected.title;
                    this.form.content = this.selected.content
                }
            },
            validatePost() {
                this.$v.$touch();

                if (!this.$v.$invalid) {
                    if (this.createDialog) {
                        this.savePost();
                    } else {
                        this.updatePost()
                    }
                }
            },
            getValidationClass(fieldName) {
                const field = this.$v.form[fieldName]

                if (field) {
                    return {
                        'md-invalid': field.$invalid && field.$dirty
                    }
                }
            },
            updatePost() {
                this.sending = true;
                this.lastPost = {post_title: this.form.title, post_content: this.form.content};
                axios.post(`http://localhost:8888/wordpress/wp-json/wp/v2/posts/${this.selected.id}`, this.lastPost,config)
                    .then(() => {
                        this.postSaved = true;
                        this.sending = false;
                        this.clearForm();
                        this.active = false;
                        this.search();
                    })
                    .catch(function () {
                        this.postNotSaved = true;
                    });
            },
            savePost() {
                this.sending = true;
                this.lastPost = {title: this.form.title, content: this.form.content};
                axios.post('http://localhost:8888/wordpress/wp-json/my-route/v1/create', this.lastPost)
                    .then(() => {
                        this.postSaved = true;
                        this.sending = false;
                        this.clearForm();
                        this.createDialog = false;
                        this.search();
                    })
                    .catch(function () {
                        this.postNotSaved = true;
                    });
            },
            clearForm() {
                this.$v.$reset();
                this.form.title = null;
                this.form.content = null;
                this.selected = null;
            },
            onSelect(items) {
                if (!this.deletion) {
                    this.selected = items;
                    this.active = true;
                    this.patchForm();
                }
            },
            closeAdditionDialog() {
                this.clearForm();
                this.createDialog = false;
            },
            deletePost(item) {
                this.deletion = true;
                axios
                    .delete(`http://localhost:8888/wordpress/wp-json/my-route/v1/delete/${item.item.ID}`)
                    .then(() => {
                        this.search();
                        this.deletion = false;
                        this.postDeleted = true;
                    });
            }
        }

    }
</script>

<style scoped>

</style>