import PostCreator from './components/PostCreator'
import PostUpdator from './components/PostUpdator'
import HelloWorld from './components/HelloWorld'

export default [
    { path: '/custom', component: PostUpdator },
    { path: '/default', component: PostCreator },
    { path: '/list', component: HelloWorld }
]