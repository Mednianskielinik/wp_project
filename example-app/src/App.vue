<template>
    <div id="app">
        <md-toolbar class="md-primary">
                <router-link to="/default">
                    <md-button class="md-icon-button" @click="showNavigation = true">
                        <md-icon>work</md-icon>
                    </md-button>
                </router-link>
            <router-link to="/custom">
                <md-button class="md-icon-button" @click="showNavigation = true">
                    <md-icon>stars</md-icon>
                </md-button>
            </router-link>
            <router-link to="/list">
                <md-button class="md-icon-button" @click="showNavigation = true">
                    <md-icon>list</md-icon>
                </md-button>
            </router-link>

            <span class="md-title">Venera example app</span>
        </md-toolbar>
        <router-view></router-view>
    </div>
</template>

<script>
    export default {
        name: 'app',
        data: () => ({
            showNavigation: false,
            showSidepanel: false
        }),
        components: {
        },
        build: {
            extend(config) {
                config.resolve.alias['vue'] = 'vue/dist/vue.common'
            }
        }
    }
</script>

<style scoped>
    #app {
        height: 100vh;
        font-family: 'Avenir', Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        /*text-align: center;*/
        color: #2c3e50;
    }
</style>
